<?php

namespace App\Http\Controllers\ApiOse\Services;

use App\Http\Controllers\ApiOse\Data\ApiResponse;
use App\Http\Controllers\ApiOse\Data\OperationResult;
use App\Http\Controllers\ApiOse\Data\SendDocumentParams;
use App\Http\Controllers\ApiOse\Data\VoucherFolderParams;
use App\Http\Controllers\ApiOse\Models\BranchModel;
use App\Http\Controllers\ApiOse\Models\EmitterModel;
use App\Http\Controllers\ApiOse\Models\GuidesModel;
use App\Http\Controllers\ApiOse\Models\SaleModel;
use App\Http\Controllers\ApiOse\Services\apiSignature\XMLSecurityDSig;
use App\Http\Controllers\ApiOse\Services\apiSignature\XMLSecurityKey;
use Carbon\Carbon;
use DOMDocument;
use Exception;
use Illuminate\Support\Facades\Log;
use Luecano\NumeroALetras\NumeroALetras;
use ZipArchive;

class UtilService
{
    private const CERTIFICATE_PATH = 'Http/Controllers/ApiOse/Services/digitalCertificates';

    private NumeroALetras $numberFormatter;

    public function __construct()
    {
        $this->numberFormatter = new NumeroALetras();
    }

    private function createTokenToGuide(EmitterModel $emitter): ApiResponse
    {
        $apiResponse = new ApiResponse();

        $urlSunat = $emitter->secondary_user === 'MODDATOS'
            ? "https://gre-test.nubefact.com/v1/clientessol/{$emitter->client_id}/oauth2/token"
            : "https://api-seguridad.sunat.gob.pe/v1/clientessol/{$emitter->client_id}/oauth2/token";

        $curl = curl_init();

        try {
            $form_params = [
                'grant_type' => 'password',
                'scope' => 'https://api-cpe.sunat.gob.pe',
                'client_id' => $emitter->client_id,
                'client_secret' => $emitter->client_secret,
                'username' => $emitter->document . $emitter->secondary_user,
                'password' => $emitter->secondary_user_password,
            ];

            curl_setopt_array($curl, array(
                CURLOPT_URL => $urlSunat,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($form_params),
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            ));

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                throw new Exception("problemas de conexión con la SUNAT al obtener el token para las guias de remisión " . curl_error($curl));
            }

            $dataToken = json_decode($response, true);

            if ($httpcode !== 200) {
                $code = $dataToken['cod'] ?? 0;
                $message = $dataToken['msg'] ?? 'no se puede obtener el token paras las guías remisión';

                if (array_key_exists('errors', $dataToken)) {
                    $errorCode = $dataToken['errors']['codError'];
                    $errroMessage = $dataToken['errors']['desError'];
                    $message .= " ({$errorCode} | {$errroMessage})";
                }

                throw new Exception($message, (int) $code);
            }

            $apiResponse->estado = true;
            $apiResponse->message = 'La SUNAT devolvió el token exitosamente';
            $apiResponse->dataResponse = $dataToken['access_token'];

            return $apiResponse;
        } catch (Exception $ex) {
            $apiResponse->estado = false;
            $apiResponse->code = (string) $ex->getCode();
            $apiResponse->message = $ex->getMessage();

            return $apiResponse;
        } finally {
            if (isset($curl)) {
                curl_close($curl);
            }
        }
    }

    private function ensureDirectory(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    function formatDecimal(string $value): string
    {
        $value = rtrim($value, '0');

        if (str_ends_with($value, '.')) {
            $value .= '0';
        }

        return $value;
    }

    private function getCertificatePath(string $certificateName): string
    {
        return app_path(self::CERTIFICATE_PATH . "/{$certificateName}");
    }

    public function buildXmlName(SaleModel|GuidesModel $model): string
    {
        $emitterDocument = $model->branchModel->emitterModel->document;

        return implode('-', [
            $emitterDocument,
            $model->voucher_type_code,
            $model->serie,
            $model->correlative
        ]);
    }

    public function cleanText(string $text, string $mode = ''): string
    {
        // Elimina caracteres de control (saltos de línea, tabs, etc.)
        $text = preg_replace('/[\r\n\t\f\v]+/', ' ', $text);

        // Reemplaza múltiples espacios por uno solo
        $text = preg_replace('/\s+/', ' ', $text);

        // Elimina espacios al inicio y final
        $text = trim($text);

        switch ($mode) {
            case 'ALNUM':
                // Permite solo letras y números
                $text = preg_replace('/[^a-zA-Z0-9]/', '', $text);
                break;

            case 'ALNUM_UPPER':
                // Convierte a mayúsculas
                $text = strtoupper($text);

                // Permite solo letras mayúsculas y números
                $text = preg_replace('/[^A-Z0-9]/', '', $text);

                // Si solo contiene ceros, se retorna vacío
                if (preg_match('/^0+$/', $text)) {
                    $text = '';
                }
                break;
        }

        return $text;
    }

    public function convertAmountToWords(string $total, string $coinCode, int $decimals = 2): string
    {
        $currency = match ($coinCode) {
            'PEN' => 'SOLES',
            'USD' => 'DOLARES',
            default => 'OTROS'
        };

        return strtoupper(
            $this->numberFormatter->toInvoice($total, $decimals, $currency)
        );
    }

    public function createDOMDocument(): DOMDocument
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = false;
        $doc->preserveWhiteSpace = true;

        return $doc;
    }

    public function createVoucherDirectories(VoucherFolderParams $voucherFolderParams): array
    {
        $folderName = match ($voucherFolderParams->voucher_type_code) {
            '01' => 'Facturas',
            '03' => 'Boletas',
            '07' => 'NotaCreditos',
            '08' => 'NotaDebitos',
            '09' => 'GuiaRemicionRemitentes',
            '31' => 'GuiaRemicionTransportistas',
            default => 'OtrosComprobantes'
        };

        $dateObj = Carbon::parse($voucherFolderParams->date);

        $year = $dateObj->year;
        $month = $dateObj->locale('es')->translatedFormat('F');

        $basePath = public_path(
            "Comprobantes/{$voucherFolderParams->emitter_document}/{$folderName}/{$year}/{$month}/{$voucherFolderParams->xml_name}"
        );
        $cdrPath = "{$basePath}/CDR";

        $this->ensureDirectory($basePath);
        $this->ensureDirectory($cdrPath);

        return [
            'xmlPath' => $basePath,
            'cdrPath' => $cdrPath,
        ];
    }

    public function createZipAndEncode(string $zipPath, string $xmlPath, string $xmlName): array
    {
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            throw new Exception("No se pudo crear el archivo ZIP {$zipPath}");
        }

        $zip->addFile($xmlPath, $xmlName);
        $zip->close();

        $zipContent = file_get_contents($zipPath);

        return [
            'base64' => base64_encode($zipContent),
            'sha256' => hash('sha256', $zipContent),
        ];
    }

    public function getBranch(): BranchModel
    {
        $emitterModel = new EmitterModel();
        $emitterModel->document = '20601599881';
        $emitterModel->company_name = 'CISNERGIA PERU S.A.C.';
        $emitterModel->trade_name = 'CISNERGIA';
        $emitterModel->detraction_account = '00043342343243';
        $emitterModel->client_id = 'test-85e5b0ae-255c-4891-a595-0b98c65c9854';
        $emitterModel->client_secret = 'test-Hty/M6QshYvPgItX2P0+Kw==';
        $emitterModel->secondary_user = 'MODDATOS';
        $emitterModel->secondary_user_password = 'MODDATOS';
        $emitterModel->certificate_name = '20601599881.pfx';
        $emitterModel->certificate_password = '20601599881';
        $emitterModel->certificate_start_date = '2026-03-05';
        $emitterModel->certificate_end_date = '2027-03-05';

        $branchModel = new BranchModel();
        $branchModel->emitterModel = $emitterModel;
        $branchModel->local_code = '0000';
        $branchModel->department = 'LIMA';
        $branchModel->province = 'LIMA';
        $branchModel->district = 'MIRAFLORES';
        $branchModel->ubigeo = '150122';
        $branchModel->address = 'CAL. ATAHUALPA NRO. 210 URB. CERCADO DE MIRAFLORES DPTO. C115';

        return $branchModel;
    }

    public function padWithZeros(int $number, int $length = 8): string
    {
        return str_pad((string) $number, $length, '0', STR_PAD_LEFT);
    }

    public function reponseError(string $message): OperationResult
    {
        return new OperationResult(message: $message);
    }

    public function signXml(EmitterModel $emitterModel, string $xmlPath): OperationResult
    {
        try {
            $doc = $this->createDOMDocument();

            if (!$doc->load($xmlPath)) {
                throw new Exception("no se pudo cargar el documento XML");
            }

            $objDSig = new XMLSecurityDSig(false);
            $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, ['type' => 'private']);

            $objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);
            $objDSig->addReference(
                $doc,
                XMLSecurityDSig::SHA1,
                ['http://www.w3.org/2000/09/xmldsig#enveloped-signature'],
                [
                    'force_uri' => true,
                    'id_name' => 'ID',
                    'overwrite' => false
                ]
            );

            $certificatePath = $this->getCertificatePath($emitterModel->certificate_name);
            $pfx = file_get_contents($certificatePath);
            $key = [];

            if (!$pfx) {
                throw new Exception("no se pudo leer el certificado digital");
            }

            if (!openssl_pkcs12_read($pfx, $key, $emitterModel->certificate_password)) {
                throw new Exception("contraseña incorrecta " . openssl_error_string());
            }

            $extensionContent = $doc->documentElement->getElementsByTagName("ExtensionContent")->item(0);

            $objKey->loadKey($key["pkey"]);
            $objDSig->add509Cert($key["cert"], true, false);
            $objDSig->sign($objKey, $extensionContent);

            $signature = $doc->getElementsByTagName('Signature')->item(0);

            if ($signature) {
                $signature->setAttribute('Id', 'SignatureSP');
            }

            $doc->save($xmlPath);

            return new OperationResult(true);
        } catch (Exception $ex) {
            return $this->reponseError("error en firmar el XML {$ex->getMessage()}");
        }
    }

    public function sendSaleToOse(SendDocumentParams $params): ApiResponse
    {
        $apiResponse = new ApiResponse();
        $emitter = $params->emitterModel;

        $urlOse = $emitter->secondary_user === 'MODDATOS'
            ? 'https://demo-ose.nubefact.com/ol-ti-itcpe/billService?wsdl'
            : 'https://ose.nubefact.com/ol-ti-itcpe/billService?wsdl';

        $username = $emitter->document . $emitter->secondary_user;
        $password = $emitter->secondary_user_password;

        $soap = <<<XML
            <soapenv:Envelope
                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                xmlns:ser="http://service.sunat.gob.pe"
                xmlns:wsse="http://docs.oasisopen.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                <soapenv:Header>
                    <wsse:Security>
                        <wsse:UsernameToken>
                            <wsse:Username>{$username}</wsse:Username>
                            <wsse:Password>{$password}</wsse:Password>
                        </wsse:UsernameToken>
                    </wsse:Security>
                </soapenv:Header>
                <soapenv:Body>
                    <ser:sendBill>
                        <fileName>{$params->zipName}</fileName>
                        <contentFile>{$params->codedZip}</contentFile>
                    </ser:sendBill>
                </soapenv:Body>
            </soapenv:Envelope>
        XML;

        $curl = curl_init();

        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => $urlOse,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $soap,
                CURLOPT_HTTPHEADER => ['Content-Type: application/xml'],
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            $response = curl_exec($curl);

            if ($response === false) {
                throw new Exception("Problemas de conexión con la OSE " . curl_error($curl));
            }

            $doc = $this->createDOMDocument();

            if (!$doc->loadXML($response)) {
                throw new Exception("La respuesta de la OSE no es un XML válido {$response}");
            }

            $cdrNode = $doc->getElementsByTagName('applicationResponse')->item(0);

            if (!$cdrNode) {
                $message = $doc->getElementsByTagName('message')->item(0)?->nodeValue ?? 'problemas de validación de la OSE';
                $code = $doc->getElementsByTagName('faultstring')->item(0)?->nodeValue ?? '0';
                throw new Exception($message, (int) $code);
            }

            $apiResponse->estado = true;
            $apiResponse->message = 'La OSE devolvió el CDR con éxito';
            $apiResponse->dataResponse = $cdrNode->nodeValue;

            return $apiResponse;
        } catch (Exception $ex) {
            $apiResponse->estado = false;
            $apiResponse->code = (string) $ex->getCode();
            $apiResponse->message = $ex->getMessage();

            return $apiResponse;
        } finally {
            if (isset($curl)) {
                curl_close($curl);
            }
        }
    }

    public function sendGuideToSunat(SendDocumentParams $params, string $xmlName): ApiResponse
    {
        $apiResponse = new ApiResponse();
        $emitter = $params->emitterModel;

        $urlSunat = $emitter->secondary_user === 'MODDATOS'
            ? "https://gre-test.nubefact.com/v1/contribuyente/gem/comprobantes/{$xmlName}"
            : "https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/{$xmlName}";

        $curl = curl_init();

        try {
            $responseToken = $this->createTokenToGuide($emitter);

            if (!$responseToken->estado) {
                throw new Exception($responseToken->message, (int) $responseToken->code);
            }

            $form_params = [
                "archivo" => [
                    'nomArchivo' => $params->zipName,
                    'arcGreZip' => $params->codedZip,
                    'hashZip' => $params->codedSha,
                ],
            ];

            curl_setopt_array($curl, array(
                CURLOPT_URL => $urlSunat,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($form_params),
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$responseToken->dataResponse}",
                    'Content-Type: application/json',
                ],
            ));

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                throw new Exception("error de conexión con SUNAT en las guias de remisión " . curl_error($curl));
            }

            $dataSunat = json_decode($response, true);

            if ($httpcode !== 200) {
                $code = $dataSunat['cod'] ?? 0;
                $message = $dataSunat['msg'] ?? 'no se puede enviar las guías remisión';

                if (array_key_exists('errors', $dataSunat)) {
                    $errorCode = $dataSunat['errors']['cod'];
                    $errroMessage = $dataSunat['errors']['msg'];
                    $message .= " ({$errorCode} | {$errroMessage})";
                }

                throw new Exception($message, (int) $code);
            }

            $apiResponse->estado = true;
            $apiResponse->message = 'La SUNAT devolvió el ticket exitosamente';
            $apiResponse->dataResponse = $dataSunat['numTicket'];

            return $apiResponse;
        } catch (Exception $ex) {
            $apiResponse->estado = false;
            $apiResponse->code = (string) $ex->getCode();
            $apiResponse->message = $ex->getMessage();

            return $apiResponse;
        } finally {
            if (isset($curl)) {
                curl_close($curl);
            }
        }
    }

    public function sendGuideTicketToSunat(EmitterModel $emitter, string $ticket): ApiResponse
    {
        $apiResponse = new ApiResponse();

        $urlSunat = $emitter->secondary_user === 'MODDATOS'
            ? "https://gre-test.nubefact.com/v1/contribuyente/gem/comprobantes/envios/{$ticket}"
            : "https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/envios/{$ticket}";

        $curl = curl_init();

        try {
            $responseToken = $this->createTokenToGuide($emitter);

            if (!$responseToken->estado) {
                throw new Exception($responseToken->message, (int) $responseToken->code);
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => $urlSunat,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$responseToken->dataResponse}",
                    'Content-Type: application/json',
                ],
            ));

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                throw new Exception("error de conexión con SUNAT al consultar el ticket de la guía de remisión. " . curl_error($curl));
            }

            $dataTicket = json_decode($response, true);

            if ($httpcode !== 200) {
                $code = $dataTicket['cod'] ?? 0;
                $message = $dataTicket['msg'] ?? 'no se puede validar el el ticket de la guía remisión';

                if (array_key_exists('errors', $dataTicket)) {
                    $errorCode = $dataTicket['errors']['codError'];
                    $errroMessage = $dataTicket['errors']['desError'];
                    $message .= " ({$errorCode} | {$errroMessage})";
                }

                throw new Exception($message, (int) $code);
            }

            $codRespuesta = $dataTicket['codRespuesta'];

            if ($codRespuesta === '98') {
                throw new Exception('envío en proceso', (int) $codRespuesta);
            }

            if (!array_key_exists('indCdrGenerado', $dataTicket)) {
                $code = $dataTicket['error']['numError'];
                $message = $dataTicket['error']['desError'];
                throw new Exception($message, (int) $code);
            }

            $apiResponse->estado = true;
            $apiResponse->message = 'La guía remisión fue aceptado con exito';
            $apiResponse->dataResponse = $dataTicket['arcCdr'];

            return $apiResponse;
        } catch (Exception $ex) {
            $apiResponse->estado = false;
            $apiResponse->code = (string) $ex->getCode();
            $apiResponse->message = $ex->getMessage();

            return $apiResponse;
        } finally {
            if (isset($curl)) {
                curl_close($curl);
            }
        }
    }

    public function validateDigitalCertificate(EmitterModel $emitterModel): OperationResult
    {
        $certificatePath = $this->getCertificatePath($emitterModel->certificate_name);
        $expirationDate = Carbon::parse($emitterModel->certificate_end_date);

        if (!file_exists($certificatePath)) {
            return $this->reponseError(
                "No se encontró el certificado digital en la ruta: {$certificatePath}"
            );
        }

        if ($expirationDate->isPast()) {
            return $this->reponseError(
                "El certificado {$emitterModel->certificate_name} ha vencido el {$expirationDate->format('d/m/Y')}. Por favor, renuévalo."
            );
        }

        return new OperationResult(true);
    }

    public function unzipCdr(string $cdrPath, string $xmlName, string $codedCdr): OperationResult
    {
        try {
            $cdrPathComplete = "{$cdrPath}/R-{$xmlName}";
            $decodeCdr = base64_decode($codedCdr);
            file_put_contents("{$cdrPathComplete}.zip", $decodeCdr);

            $zipArchive = new ZipArchive();

            if ($zipArchive->open("{$cdrPathComplete}.zip") === false) {
                throw new Exception("al abrir el archivo ZIP ubicado en '{$cdrPathComplete}.zip'");
            }

            $zipArchive->extractTo($cdrPath);
            $zipArchive->close();

            // Leemos el XML del CDR
            $doc = $this->createDOMDocument();
            $doc->loadXML(file_get_contents("{$cdrPathComplete}.xml"));

            $responseCode = $doc->getElementsByTagName('ResponseCode')->item(0)->nodeValue;
            $description = $doc->getElementsByTagName('Description')->item(0)->nodeValue;
            $url = $doc->getElementsByTagName('DocumentDescription')->item(0)->nodeValue ?? '';

            if ($responseCode !== '0') {
                throw new Exception("{$responseCode} | {$description}}");
            }

            return new OperationResult(true, $description, $url);
        } catch (Exception $ex) {
            return $this->reponseError("Error en el CDR ({$ex->getMessage()})");
        }
    }
}
