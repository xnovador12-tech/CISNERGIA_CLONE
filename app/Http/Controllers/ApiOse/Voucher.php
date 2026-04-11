<?php

namespace App\Http\Controllers\ApiOse;

use App\Http\Controllers\ApiOse\Data\OperationResult;
use App\Http\Controllers\ApiOse\Data\SendDocumentParams;
use App\Http\Controllers\ApiOse\Data\VoucherFolderParams;
use App\Http\Controllers\ApiOse\Models\GuidesModel;
use App\Http\Controllers\ApiOse\Models\SaleModel;
use App\Http\Controllers\ApiOse\Services\MathService;
use App\Http\Controllers\ApiOse\Services\UtilService;
use App\Http\Controllers\ApiOse\Services\XmlGenerateService;
use Exception;

class Voucher
{
    private UtilService $utilService;
    private XmlGenerateService $xmlGenerateService;

    public function __construct()
    {
        $this->utilService = new UtilService();
        $this->xmlGenerateService = new XmlGenerateService();
    }

    private function createVoucherDirectories(SaleModel|GuidesModel $model, string $xmlName): array
    {
        $emitterModel = $model->branchModel->emitterModel;
        $voucherFolderParams = new VoucherFolderParams();
        $voucherFolderParams->voucher_type_code = $model->voucher_type_code;
        $voucherFolderParams->xml_name = $xmlName;
        $voucherFolderParams->date = $model->issue_date;
        $voucherFolderParams->emitter_document = $emitterModel->document;
        return $this->utilService->createVoucherDirectories($voucherFolderParams);
    }

    public function checkStatusToGuideTicket(GuidesModel $guidesModel, string $ticket): OperationResult
    {
        $emitterModel = $guidesModel->branchModel->emitterModel;
        $xmlName = $guidesModel->xml_name;

        try {
            // Consultar ticket
            $responseTicket = $this->utilService->sendGuideTicketToSunat($emitterModel, $ticket);

            if (!$responseTicket->estado) {
                if ($responseTicket->code === '1033') {
                    return new OperationResult(true, "La guía {$xmlName} ha sido ACEPTADA", null);
                }

                throw new Exception($responseTicket->message, (int) $responseTicket->code);
            }

            // Creamos las carpetas donde se van a guardar el XML/CDR
            $path = $this->createVoucherDirectories($guidesModel, $xmlName);
            $cdrPath = $path['cdrPath'];

            // Descomprimimos el CDR y lo guardamos en la carpeta
            $responseCdr = $this->utilService->unzipCdr($cdrPath, $xmlName, $responseTicket->dataResponse);

            if (!$responseCdr->estado) {
                throw new Exception($responseCdr->message);
            }

            return $responseCdr;
        } catch (Exception $ex) {
            return $this->utilService->reponseError(
                "Error en la consulta del ticket de la guía {$guidesModel->serie}-{$guidesModel->correlative}: {$ex->getMessage()}"
            );
        }
    }

    public function sale(SaleModel $saleModel): OperationResult
    {
        $emitterModel = $saleModel->branchModel->emitterModel;
        $xmlName = $saleModel->xml_name;

        try {
            $responseCertificate = $this->utilService->validateDigitalCertificate($emitterModel);

            if (!$responseCertificate->estado) {
                throw new Exception($responseCertificate->message);
            }

            if ($saleModel->exonerated_operation === '1001' && !$emitterModel->detraction_account) {
                throw new Exception("Ingrese una cuenta de detracción");
            }

            if ($saleModel->clientModel->document === $emitterModel->document) {
                throw new Exception("El cliente no puede ser el mismo que el emisor");
            }

            if (!MathService::isGreaterThanZero($saleModel->total)) {
                throw new Exception("El total debe ser mayor a 0");
            }

            // Creamos las carpetas donde se van a guardar el XML/CDR
            $path = $this->createVoucherDirectories($saleModel, $xmlName);
            $xmlPath = "{$path['xmlPath']}/{$xmlName}";
            $cdrPath = $path['cdrPath'];

            // Generamos los XML de Boletas/Facturas/NOTAS DE CREDITO/DEBITO
            $responseXml = $this->xmlGenerateService->sale($saleModel, "{$xmlPath}.xml");

            if (!$responseXml->estado) {
                throw new Exception($responseXml->message);
            }

            // Firmamos los XML de Boletas/Facturas/NOTAS DE CREDITO/DEBITO
            $responseSing = $this->utilService->signXml($emitterModel, "{$xmlPath}.xml");

            if (!$responseSing->estado) {
                throw new Exception($responseSing->message);
            }

            // Encriptamos los XML de Boletas/Facturas/NOTAS DE CREDITO/DEBITO
            $responseZipEncode = $this->utilService->createZipAndEncode("{$xmlPath}.zip", "{$xmlPath}.xml", "{$xmlName}.xml");
            $codedZip = $responseZipEncode['base64'];

            // Enviamos el XML a la OSE NUBEFACT
            $sendDocumentParams = new SendDocumentParams();
            $sendDocumentParams->emitterModel = $emitterModel;
            $sendDocumentParams->zipName = "{$xmlName}.zip";
            $sendDocumentParams->codedZip = $codedZip;
            $responseOse = $this->utilService->sendSaleToOse($sendDocumentParams);

            if (!$responseOse->estado) {
                if ($responseOse->code === '1033') {
                    return new OperationResult(true, "El comprobate {$xmlName} ha sido ACEPTADA");
                }

                throw new Exception("Erro API OSE Codigo ({$responseOse->code}) | {$responseOse->message}");
            }

            if (empty(trim($responseOse->dataResponse))) {
                return new OperationResult(true, "El comprobate {$xmlName} ha sido ACEPTADA pero sin CDR");
            }

            // Descomprimimos el CDR y lo guardamos en la carpeta
            $responseCdr = $this->utilService->unzipCdr($cdrPath, $xmlName, $responseOse->dataResponse);

            if (!$responseCdr->estado) {
                throw new Exception($responseCdr->message);
            }

            return $responseCdr;
        } catch (Exception $ex) {
            return $this->utilService->reponseError(
                "Error en el procesamiento del comprobante {$saleModel->serie}-{$saleModel->correlative}: {$ex->getMessage()}"
            );
        }
    }

    public function guide(GuidesModel $guidesModel): OperationResult
    {
        $emitterModel = $guidesModel->branchModel->emitterModel;
        $xmlName = $guidesModel->xml_name;

        try {
            $responseCertificate = $this->utilService->validateDigitalCertificate($emitterModel);

            if (!$responseCertificate->estado) {
                throw new Exception($responseCertificate->message);
            }

            // Creamos las carpetas donde se van a guardar el XML/CDR
            $path = $this->createVoucherDirectories($guidesModel, $xmlName);
            $xmlPath = "{$path['xmlPath']}/{$xmlName}";
            $cdrPath = $path['cdrPath'];

            // Generamos los XML de Boletas/Facturas/NOTAS DE CREDITO/DEBITO
            $responseXml = $this->xmlGenerateService->guide($guidesModel, "{$xmlPath}.xml");

            if (!$responseXml->estado) {
                throw new Exception($responseXml->message);
            }

            // Firmamos los XML de GUÍAS DE REMISIÓN REMITENTE/TRANSPORTISTA
            $responseSing = $this->utilService->signXml($emitterModel, "{$xmlPath}.xml");

            if (!$responseSing->estado) {
                throw new Exception($responseSing->message);
            }

            // Encriptamos los XML de Boletas/Facturas/NOTAS DE CREDITO/DEBITO
            $responseZipEncode = $this->utilService->createZipAndEncode("{$xmlPath}.zip", "{$xmlPath}.xml", "{$xmlName}.xml");
            $codedZip = $responseZipEncode['base64'];
            $codedSha = $responseZipEncode['sha256'];

            // Enviamos el XML a SUNAT
            $sendDocumentParams = new SendDocumentParams();
            $sendDocumentParams->emitterModel = $emitterModel;
            $sendDocumentParams->zipName = "{$xmlName}.zip";
            $sendDocumentParams->codedZip = $codedZip;
            $sendDocumentParams->codedSha = $codedSha;
            $responseSunat = $this->utilService->sendGuideToSunat($sendDocumentParams, $xmlName);

            return new OperationResult(true, $responseSunat->message, $responseSunat->dataResponse);
        } catch (Exception $ex) {
            return $this->utilService->reponseError(
                "Error en el procesamiento de la guía {$guidesModel->serie}-{$guidesModel->correlative}: {$ex->getMessage()}"
            );
        }
    }
}
