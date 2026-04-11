<?php

namespace App\Http\Controllers\ApiOse\Services;

use App\Http\Controllers\ApiOse\Data\OperationResult;
use App\Http\Controllers\ApiOse\Data\PartyParams;
use App\Http\Controllers\ApiOse\Data\TaxSubtotalParams;
use App\Http\Controllers\ApiOse\Models\EmitterModel;
use App\Http\Controllers\ApiOse\Models\GuideDetailModel;
use App\Http\Controllers\ApiOse\Models\GuidePlateModel;
use App\Http\Controllers\ApiOse\Models\GuidesModel;
use App\Http\Controllers\ApiOse\Models\SaleDetailModel;
use App\Http\Controllers\ApiOse\Models\SaleModel;
use App\Http\Controllers\ApiOse\Models\SaleQuotaModel;
use DOMDocument;
use DOMElement;
use Exception;

class XmlGenerateService
{
    private DOMDocument $doc;
    private UtilService $utilService;
    private string $UBLVersionID = '2.1';
    private string $CustomizationID = '2.0';

    public function __construct()
    {
        $this->utilService = new UtilService();
    }

    private function createElement(string $name, ?string $value = '', array $attributes = []): DOMElement
    {
        $element = $this->doc->createElement($name);

        if ($value !== null) {
            $element->nodeValue = htmlspecialchars($value);
        }

        foreach ($attributes as $key => $attr) {
            $element->setAttribute($key, $attr);
        }

        return $element;
    }

    private function createElementRoot(string $rootElement): DOMElement
    {
        $element = $this->createElement($rootElement, attributes: [
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xmlns:cac' => 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2',
            'xmlns:cbc' => 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2',
            'xmlns:ccts' => 'urn:un:unece:uncefact:documentation:2',
            'xmlns:ds' => 'http://www.w3.org/2000/09/xmldsig#',
            'xmlns:ext' => 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2',
            'xmlns:qdt' => 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2',
            'xmlns:udt' => 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2',
            'xmlns' => "urn:oasis:names:specification:ubl:schema:xsd:{$rootElement}-2",
        ]);

        return $element;
    }

    private function createElementItem(string $description, string $code): DOMElement
    {
        $item = $this->createElement('cac:Item');

        // Item -> Description
        $description = $this->createElement('cbc:Description', $description);
        $item->appendChild($description);

        // Item -> SellersItemIdentification
        $sellersItemIdentification = $this->createElement('cac:SellersItemIdentification');
        $item->appendChild($sellersItemIdentification);

        // Item -> SellersItemIdentification -> ID
        $sellersItemIdentification->appendChild($this->createElement('cbc:ID', $code));

        return $item;
    }

    private function createElementParty(PartyParams $partyParams): DOMElement
    {
        $party = $this->createElement('cac:Party');

        // Party -> PartyIdentification
        $partyIdentification = $this->createElement('cac:PartyIdentification');
        $party->appendChild($partyIdentification);

        // Party -> PartyIdentification -> ID
        $partyIdentification->appendChild($this->createElement('cbc:ID', $partyParams->document, [
            'schemeID' => $partyParams->document_type,
            'schemeName' => 'Documento de Identidad',
            'schemeAgencyName' => 'PE:SUNAT',
            'schemeURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06',
        ]));

        // Nombre comercial opcional
        if (!empty($partyParams->trade_name)) {
            // Party -> PartyName
            $partyName = $this->createElement('cac:PartyName');
            $party->appendChild($partyName);

            // Party -> PartyName -> Name
            $partyName->appendChild($this->createElement('cbc:Name', $partyParams->trade_name));
        }

        // Party -> PartyLegalEntity
        $partyLegalEntity = $this->createElement('cac:PartyLegalEntity');
        $party->appendChild($partyLegalEntity);

        // Party -> PartyLegalEntity -> RegistrationName
        $partyLegalEntity->appendChild($this->createElement('cbc:RegistrationName', $partyParams->company_name));

        if (array_filter([
            $partyParams->ubigeo,
            $partyParams->local_code,
            $partyParams->province,
            $partyParams->department,
            $partyParams->district,
            $partyParams->address,
            $partyParams->country_code,
        ])) {
            // Party -> PartyLegalEntity -> RegistrationAddress
            $registrationAddress = $this->createElement('cac:RegistrationAddress');
            $partyLegalEntity->appendChild($registrationAddress);

            if (!empty($partyParams->ubigeo)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> ID
                $registrationAddress->appendChild($this->createElement('cbc:ID', $partyParams->ubigeo, [
                    'schemeName' => 'Ubigeos',
                    'schemeAgencyName' => 'PE:INEI',
                ]));
            }

            if (!empty($partyParams->local_code)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> AddressTypeCode
                $registrationAddress->appendChild($this->createElement('cbc:AddressTypeCode', $partyParams->local_code, [
                    'listAgencyName' => 'PE:SUNAT',
                    'listName' => 'Establecimientos anexos',
                ]));
            }

            if (!empty($partyParams->province)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> CityName
                $registrationAddress->appendChild($this->createElement('cbc:CityName', $partyParams->province));
            }

            if (!empty($partyParams->province)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> CountrySubentity
                $registrationAddress->appendChild($this->createElement('cbc:CountrySubentity', $partyParams->department));
            }

            if (!empty($partyParams->district)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> District
                $registrationAddress->appendChild($this->createElement('cbc:District', $partyParams->district));
            }

            if (!empty($partyParams->address)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> AddressLine
                $addressLine = $this->createElement('cac:AddressLine');
                $registrationAddress->appendChild($addressLine);

                // Party -> PartyLegalEntity -> RegistrationAddress -> AddressLine -> Line
                $addressLine->appendChild($this->createElement('cbc:Line', $partyParams->address));
            }

            if (!empty($partyParams->country_code)) {
                // Party -> PartyLegalEntity -> RegistrationAddress -> Country
                $country = $this->createElement('cac:Country');
                $registrationAddress->appendChild($country);

                // Party -> PartyLegalEntity -> RegistrationAddress -> Country -> IdentificationCode
                $country->appendChild($this->createElement('cbc:IdentificationCode', $partyParams->country_code));
            }
        }

        return $party;
    }

    private function createElementSignature(EmitterModel $emitterModel): DOMElement
    {
        // Elemento principal Signature
        $signature = $this->doc->createElement('cac:Signature');

        $signature->appendChild($this->createElement('cbc:ID', $emitterModel->document));

        if ($emitterModel->trade_name) {
            $signature->appendChild($this->createElement('cbc:Note', $emitterModel->trade_name));
        }

        // SignatoryParty
        $signatoryParty = $this->doc->createElement('cac:SignatoryParty');
        $signature->appendChild($signatoryParty);

        // SignatoryParty -> PartyIdentification
        $partyIdentification = $this->doc->createElement('cac:PartyIdentification');
        $signatoryParty->appendChild($partyIdentification);

        // SignatoryParty -> PartyIdentification -> ID
        $partyIdentification->appendChild($this->createElement('cbc:ID', $emitterModel->document));

        // SignatoryParty -> PartyName
        $partyName = $this->doc->createElement('cac:PartyName');
        $signatoryParty->appendChild($partyName);

        // SignatoryParty -> PartyName -> Name
        $partyName->appendChild($this->createElement('cbc:Name', $emitterModel->company_name));

        // DigitalSignatureAttachment
        $digitalSignatureAttachment = $this->doc->createElement('cac:DigitalSignatureAttachment');
        $signature->appendChild($digitalSignatureAttachment);

        // DigitalSignatureAttachment -> ExternalReference
        $externalReference = $this->doc->createElement('cac:ExternalReference');
        $digitalSignatureAttachment->appendChild($externalReference);

        // DigitalSignatureAttachment -> ExternalReference -> URI
        $externalReference->appendChild($this->createElement('cbc:URI', $emitterModel->document));

        return $signature;
    }

    private function createElementTaxSubtotal(TaxSubtotalParams $taxSubtotalParams): DOMElement
    {
        $taxSubtotal = $this->createElement('cac:TaxSubtotal');

        // TaxSubtotal -> TaxableAmount
        $taxableAmount = $this->createElement('cbc:TaxableAmount', $taxSubtotalParams->total, [
            'currencyID' => $taxSubtotalParams->coin_code
        ]);
        $taxSubtotal->appendChild($taxableAmount);

        // TaxSubtotal -> TaxAmount
        $taxableAmount = $this->createElement('cbc:TaxAmount', $taxSubtotalParams->igv, [
            'currencyID' => $taxSubtotalParams->coin_code
        ]);
        $taxSubtotal->appendChild($taxableAmount);

        // TaxSubtotal -> TaxCategory
        $taxCategory = $this->createElement('cac:TaxCategory');
        $taxSubtotal->appendChild($taxCategory);

        if (!empty($taxSubtotalParams->percentage)) {
            // TaxSubtotal -> TaxCategory -> Percent
            $percent = $this->createElement('cbc:Percent', $taxSubtotalParams->percentage);
            $taxCategory->appendChild($percent);
        }

        if (!empty($taxSubtotalParams->code)) {
            // TaxSubtotal -> TaxCategory -> Percent
            $taxExemptionReasonCode = $this->createElement('cbc:TaxExemptionReasonCode', $taxSubtotalParams->code, [
                'listAgencyName' => 'PE:SUNAT',
                'listName' => 'Afectacion del IGV',
                'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07',
            ]);
            $taxCategory->appendChild($taxExemptionReasonCode);
        }

        // TaxSubtotal -> TaxCategory -> TaxScheme
        $taxScheme = $this->createElement('cac:TaxScheme');
        $taxCategory->appendChild($taxScheme);

        // TaxSubtotal -> TaxCategory -> TaxScheme -> ID
        $ID = $this->createElement('cbc:ID', $taxSubtotalParams->tribute_code, [
            'schemeName' => 'Codigo de tributos',
            'schemeAgencyName' => 'PE:SUNAT',
            'schemeURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05',
        ]);
        $taxScheme->appendChild($ID);

        // TaxSubtotal -> TaxCategory -> TaxScheme -> Name
        $name = $this->createElement('cbc:Name', $taxSubtotalParams->tribute_name);
        $taxScheme->appendChild($name);

        // TaxSubtotal -> TaxCategory -> TaxScheme -> TaxTypeCode
        $taxTypeCode = $this->createElement('cbc:TaxTypeCode', $taxSubtotalParams->tribute_type);
        $taxScheme->appendChild($taxTypeCode);

        return $taxSubtotal;
    }

    private function createElementUblExtensions(): DOMElement
    {
        $ublExtensions = $this->doc->createElement('ext:UBLExtensions');

        $ublExtension = $this->doc->createElement('ext:UBLExtension');
        $ublExtensions->appendChild($ublExtension);

        $extensionContent = $this->doc->createElement('ext:ExtensionContent');
        $ublExtension->appendChild($extensionContent);

        return $ublExtensions;
    }

    private function resetDocument(): void
    {
        $this->doc = $this->utilService->createDOMDocument();
    }

    private function getSaleXmlConfig(string $voucherTypeCode): array
    {
        return match ($voucherTypeCode) {
            '07' => [
                'root' => 'CreditNote',
                'totalTag' => 'LegalMonetaryTotal',
                'quantityTag' => 'CreditedQuantity'
            ],
            '08' => [
                'root' => 'DebitNote',
                'totalTag' => 'RequestedMonetaryTotal',
                'quantityTag' => 'DebitedQuantity'
            ],
            '09', '31' => [
                'root' => 'DespatchAdvice',
            ],
            default => [
                'root' => 'Invoice',
                'totalTag' => 'LegalMonetaryTotal',
                'quantityTag' => 'InvoicedQuantity'
            ]
        };
    }

    public function sale(SaleModel $saleModel, string $xmlPath): OperationResult
    {
        try {
            $this->resetDocument();
            $branchModel = $saleModel->branchModel;
            $emitterModel = $branchModel->emitterModel;
            $clientModel = $saleModel->clientModel;

            $config = $this->getSaleXmlConfig($saleModel->voucher_type_code);
            $rootElement = $config['root'];
            $totalElement = $config['totalTag'];
            $quantityElement = $config['quantityTag'];

            /*
            |--------------------------------------------------------------------------
            | ROOT
            |--------------------------------------------------------------------------
            */
            $root = $this->createElementRoot($rootElement);
            $this->doc->appendChild($root);

            /*
            |--------------------------------------------------------------------------
            | UBL EXTENSIONS FIRMA
            |--------------------------------------------------------------------------
            */
            $root->appendChild($this->createElementUblExtensions());

            /*
            |--------------------------------------------------------------------------
            | VERSIÓN
            |--------------------------------------------------------------------------
            */
            $root->appendChild($this->createElement('cbc:UBLVersionID', $this->UBLVersionID));
            $root->appendChild($this->createElement('cbc:CustomizationID', $this->CustomizationID));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL COMPROBANTE
            |--------------------------------------------------------------------------
            */
            $root->appendChild($this->createElement('cbc:ID', "{$saleModel->serie}-{$saleModel->correlative}"));
            $root->appendChild($this->createElement('cbc:IssueDate', $saleModel->issue_date));
            $root->appendChild($this->createElement('cbc:IssueTime', $saleModel->hour));

            if ($saleModel->voucher_type_code !== '07' && $saleModel->voucher_type_code !== '08') {
                $root->appendChild($this->createElement('cbc:DueDate', $saleModel->expiration_date));
                $root->appendChild($this->createElement('cbc:InvoiceTypeCode', $saleModel->voucher_type_code, [
                    'listID' => $saleModel->operation_type_code,
                    'listAgencyName' => 'PE:SUNAT',
                    'listName' => 'Tipo de Documento',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01',
                    'name' => 'Tipo de Operacion',
                    'listSchemeURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo51',
                ]));
            }

            $root->appendChild($this->createElement(
                'cbc:Note',
                $this->utilService->convertAmountToWords($saleModel->total, $saleModel->coin_code),
                ['languageLocaleID' => '1000']
            ));

            // Solo si el comprobate tiene detracción
            if ($saleModel->operation_type_code === '1001' && !empty($saleModel->detractionModel)) {
                $root->appendChild($this->createElement('cbc:Note', 'Operacion sujeta a detraccion', [
                    'languageLocaleID' => '2006',
                ]));
            }

            if (!empty($saleModel->observation)) {
                $root->appendChild($this->createElement('cbc:Note', $saleModel->observation));
            }

            $root->appendChild($this->createElement('cbc:DocumentCurrencyCode', $saleModel->coin_code, [
                'listID' => 'ISO 4217 Alpha',
                'listAgencyName' => 'United Nations Economic Commission for Europe',
                'listName' => 'Currency',
            ]));

            // Solo para Notas de CREDITO/DEBITO
            if ($saleModel->voucher_type_code === '07' || $saleModel->voucher_type_code === '08') {
                // DiscrepancyResponse
                $discrepancyResponse = $this->createElement('cac:DiscrepancyResponse');
                $root->appendChild($discrepancyResponse);

                $saleReferenceModel = $saleModel->saleReferenceModel;
                $saleReference = "{$saleReferenceModel->saleModel->serie}-{$saleReferenceModel->saleModel->correlative}";

                // DiscrepancyResponse -> ReferenceID
                $discrepancyResponse->appendChild($this->createElement('cbc:ReferenceID', $saleReference));

                // DiscrepancyResponse -> ResponseCode
                $discrepancyResponse->appendChild($this->createElement('cbc:ResponseCode', $saleReferenceModel->reason_code));

                // DiscrepancyResponse -> Description
                $discrepancyResponse->appendChild($this->createElement('cbc:Description', $saleReferenceModel->reason_description));

                // BillingReference
                $billingReference = $this->createElement('cac:BillingReference');
                $root->appendChild($billingReference);

                // BillingReference -> InvoiceDocumentReference
                $invoiceDocumentReference = $this->createElement('cac:InvoiceDocumentReference');
                $billingReference->appendChild($invoiceDocumentReference);

                // BillingReference -> InvoiceDocumentReference -> ID
                $invoiceDocumentReference->appendChild($this->createElement('cbc:ID', $saleReference));

                // BillingReference -> InvoiceDocumentReference -> DocumentTypeCode
                $invoiceDocumentReference->appendChild($this->createElement('cbc:DocumentTypeCode', $saleReferenceModel->saleModel->voucher_type_code));
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL LAS GUÍAS RELACIONAS A LA VENTA
            |--------------------------------------------------------------------------
            */
            /** @var GuidesModel $gui */
            foreach ($saleModel->sale_guides as $gui) {
                // DespatchDocumentReference
                $despatchDocumentReference = $this->createElement('cac:DespatchDocumentReference');
                $root->appendChild($despatchDocumentReference);

                // DespatchDocumentReference -> ID
                $despatchDocumentReference->appendChild($this->createElement('cbc:ID', "{$gui->serie}-{$gui->correlative}"));

                // DespatchDocumentReference -> DocumentTypeCode
                $despatchDocumentReference->appendChild($this->createElement('cbc:DocumentTypeCode', $gui->voucher_type_code, [
                    'listAgencyName' => 'PE:SUNAT',
                    'listName' => 'Tipo de Documento',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01',
                ]));
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL EMISOR
            |--------------------------------------------------------------------------
            */
            $signature = $this->createElementSignature($emitterModel);
            $root->appendChild($signature);

            $accountingSupplierParty = $this->createElement('cac:AccountingSupplierParty');
            $root->appendChild($accountingSupplierParty);

            // AccountingSupplierParty -> Party
            $partyParamsEmitter = new PartyParams();
            $partyParamsEmitter->document_type = $emitterModel->document_type;
            $partyParamsEmitter->document = $emitterModel->document;
            $partyParamsEmitter->company_name = $emitterModel->company_name;
            $partyParamsEmitter->trade_name = $emitterModel->trade_name;
            $partyParamsEmitter->ubigeo = $branchModel->ubigeo;
            $partyParamsEmitter->local_code = $branchModel->local_code;
            $partyParamsEmitter->province = $branchModel->province;
            $partyParamsEmitter->department = $branchModel->department;
            $partyParamsEmitter->district = $branchModel->district;
            $partyParamsEmitter->address = $branchModel->address;
            $partyParamsEmitter->country_code = $emitterModel->country_code;
            $accountingSupplierParty->appendChild($this->createElementParty($partyParamsEmitter));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL CLIENTE
            |--------------------------------------------------------------------------
            */
            $accountingCustomerParty = $this->createElement('cac:AccountingCustomerParty');
            $root->appendChild($accountingCustomerParty);

            // AccountingCustomerParty -> Party
            $partyParamsClient = new PartyParams();
            $partyParamsClient->document_type = $clientModel->document_type;
            $partyParamsClient->document = $clientModel->document;
            $partyParamsClient->company_name = $clientModel->company_name;
            $partyParamsClient->address = $clientModel->address;
            $accountingCustomerParty->appendChild($this->createElementParty($partyParamsClient));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL LA DETRACCIÓN
            |--------------------------------------------------------------------------
            */
            if ($saleModel->operation_type_code === '1001' && !empty($saleModel->detractionModel)) {
                // PaymentMeans
                $paymentMeans = $this->createElement('cac:PaymentMeans');
                $root->appendChild($paymentMeans);

                // PaymentMeans -> ID
                $paymentMeans->appendChild($this->createElement('cbc:ID', 'Detraccion'));

                // PaymentMeans -> PaymentMeansCode
                $paymentMeans->appendChild($this->createElement('cbc:PaymentMeansCode', $saleModel->detractionModel->half_payment, [
                    'listName' => 'Medio de pago',
                    'listAgencyName' => 'PE:SUNAT',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo59',
                ]));

                // PaymentMeans -> PayeeFinancialAccount
                $payeeFinancialAccount = $this->createElement('cac:PayeeFinancialAccount');
                $paymentMeans->appendChild($payeeFinancialAccount);

                // PaymentMeans -> PayeeFinancialAccount -> ID
                $payeeFinancialAccount->appendChild($this->createElement('cbc:ID', $emitterModel->detraction_account));

                // PaymentTerms
                $paymentTermsDetraction = $this->createElement('cac:PaymentTerms');
                $root->appendChild($paymentTermsDetraction);

                // PaymentTerms -> ID
                $paymentTermsDetraction->appendChild($this->createElement('cbc:ID', 'Detraccion'));

                // PaymentTerms -> PaymentMeansID
                $paymentTermsDetraction->appendChild($this->createElement('cbc:PaymentMeansID', $saleModel->detractionModel->detraction_type, [
                    'schemeName' => 'Codigo de detraccion',
                    'schemeAgencyName' => 'PE:SUNAT',
                    'schemeURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo54',
                ]));

                // PaymentTerms -> PaymentPercent
                $paymentTermsDetraction->appendChild($this->createElement('cbc:PaymentPercent', $saleModel->detractionModel->percentage));

                // PaymentTerms -> Amount
                $paymentTermsDetraction->appendChild($this->createElement('cbc:Amount', $saleModel->detractionModel->total, [
                    'currencyID' => 'PEN'
                ]));
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL LA FACTURA CONTADO/CREDITO
            |--------------------------------------------------------------------------
            */
            if ($saleModel->voucher_type_code === '01') {
                // PaymentTerms
                $paymentTermsMethod = $this->createElement('cac:PaymentTerms');
                $root->appendChild($paymentTermsMethod);

                // PaymentTerms -> ID
                $paymentTermsMethod->appendChild($this->createElement('cbc:ID', 'FormaPago'));

                // PaymentTerms -> PaymentMeansID
                $paymentTermsMethod->appendChild($this->createElement('cbc:PaymentMeansID', $saleModel->payment_method));

                if ($saleModel->payment_method === 'Credito') {
                    // PaymentTerms -> Amount
                    $paymentTermsMethod->appendChild($this->createElement('cbc:Amount', $saleModel->pending_amount, [
                        'currencyID' => $saleModel->coin_code
                    ]));

                    // CUOTAS DE LA FACTURA
                    /** @var SaleQuotaModel $dt */
                    foreach ($saleModel->sale_quotas as $dt) {
                        // PaymentTerms
                        $paymentTermsQuota = $this->createElement('cac:PaymentTerms');
                        $root->appendChild($paymentTermsQuota);

                        // PaymentTerms -> ID
                        $paymentTermsQuota->appendChild($this->createElement('cbc:ID', 'FormaPago'));

                        // PaymentTerms -> PaymentMeansID
                        $paymentTermsQuota->appendChild($this->createElement('cbc:PaymentMeansID', $dt->name));

                        // PaymentTerms -> Amount
                        $paymentTermsQuota->appendChild($this->createElement('cbc:Amount', $dt->amount, [
                            'currencyID' => $saleModel->coin_code
                        ]));

                        // PaymentTerms -> PaymentDueDate
                        $paymentTermsQuota->appendChild($this->createElement('cbc:PaymentDueDate', $dt->date));
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL LOS TIPO IGV GRABADAS/INAFECTAS/EXONERADAS
            |--------------------------------------------------------------------------
            */
            $totalTypesIGV = '0.0';
            $totalTaxeIgv = $this->createElement('cac:TaxTotal');
            $root->appendChild($totalTaxeIgv);

            // TaxTotal -> TaxAmount
            $totalTaxeIgv->appendChild($this->createElement('cbc:TaxAmount', $saleModel->igv, [
                'currencyID' => $saleModel->coin_code
            ]));

            // GRABADAS
            if (MathService::isGreaterThanZero($saleModel->taxed_operation)) {
                $taxSubtotalParamsTaxed = new TaxSubtotalParams();
                $taxSubtotalParamsTaxed->coin_code = $saleModel->coin_code;
                $taxSubtotalParamsTaxed->total = $saleModel->taxed_operation;
                $taxSubtotalParamsTaxed->igv = $saleModel->igv;
                $taxSubtotalParamsTaxed->tribute_code = '1000';
                $taxSubtotalParamsTaxed->tribute_name = 'IGV';
                $taxSubtotalParamsTaxed->tribute_type = 'VAT';
                $totalTaxeIgv->appendChild($this->createElementTaxSubtotal($taxSubtotalParamsTaxed));
                $totalTypesIGV = MathService::sum($totalTypesIGV, $saleModel->taxed_operation);
            }

            // EXONERADAS
            if (MathService::isGreaterThanZero($saleModel->exonerated_operation)) {
                $taxSubtotalParamsExonerated = new TaxSubtotalParams();
                $taxSubtotalParamsExonerated->coin_code = $saleModel->coin_code;
                $taxSubtotalParamsExonerated->total = $saleModel->exonerated_operation;
                $taxSubtotalParamsExonerated->igv = '0.0';
                $taxSubtotalParamsExonerated->tribute_code = '9997';
                $taxSubtotalParamsExonerated->tribute_name = 'EXO';
                $taxSubtotalParamsExonerated->tribute_type = 'VAT';
                $totalTaxeIgv->appendChild($this->createElementTaxSubtotal($taxSubtotalParamsExonerated));
                $totalTypesIGV = MathService::sum($totalTypesIGV, $saleModel->exonerated_operation);
            }

            // INAFECTAS
            if (MathService::isGreaterThanZero($saleModel->unaffected_operation)) {
                $taxSubtotalParamsUnaffected = new TaxSubtotalParams();
                $taxSubtotalParamsUnaffected->coin_code = $saleModel->coin_code;
                $taxSubtotalParamsUnaffected->total = $saleModel->unaffected_operation;
                $taxSubtotalParamsUnaffected->igv = '0.0';
                $taxSubtotalParamsUnaffected->tribute_code = '9998';
                $taxSubtotalParamsUnaffected->tribute_name = 'INA';
                $taxSubtotalParamsUnaffected->tribute_type = 'FRE';
                $totalTaxeIgv->appendChild($this->createElementTaxSubtotal($taxSubtotalParamsUnaffected));
                $totalTypesIGV = MathService::sum($totalTypesIGV, $saleModel->unaffected_operation);
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL TOTAL DEL COMPROBANTE
            |--------------------------------------------------------------------------
            */
            $rootTotalElement = $this->createElement("cac:{$totalElement}");
            $root->appendChild($rootTotalElement);

            $rootTotalElement->appendChild($this->createElement('cbc:LineExtensionAmount', $totalTypesIGV, [
                'currencyID' => $saleModel->coin_code
            ]));
            $rootTotalElement->appendChild($this->createElement('cbc:TaxInclusiveAmount', $saleModel->total, [
                'currencyID' => $saleModel->coin_code
            ]));
            $rootTotalElement->appendChild($this->createElement('cbc:AllowanceTotalAmount', '0.0', [
                'currencyID' => $saleModel->coin_code
            ]));
            $rootTotalElement->appendChild($this->createElement('cbc:ChargeTotalAmount', '0.0', [
                'currencyID' => $saleModel->coin_code
            ]));
            $rootTotalElement->appendChild($this->createElement('cbc:PrepaidAmount', '0.0', [
                'currencyID' => $saleModel->coin_code
            ]));
            $rootTotalElement->appendChild($this->createElement('cbc:PayableAmount', $saleModel->total, [
                'currencyID' => $saleModel->coin_code
            ]));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL DETALLE PRODUCTO
            |--------------------------------------------------------------------------
            */
            /** @var SaleDetailModel $dt */
            foreach ($saleModel->sale_details as $dt) {
                $productModel = $dt->productModel;
                $rootLine = $this->createElement("cac:{$rootElement}Line");
                $root->appendChild($rootLine);

                $rootLine->appendChild($this->createElement('cbc:ID', $dt->item));
                $rootLine->appendChild($this->createElement("cbc:{$quantityElement}", $dt->amout, [
                    'unitCode' => $productModel->unit_code,
                    'unitCodeListID' => 'UN/ECE rec 20',
                    'unitCodeListAgencyName' => 'United Nations Economic Commission for Europe',
                ]));
                $rootLine->appendChild($this->createElement('cbc:LineExtensionAmount', $dt->total_value, [
                    'currencyID' => $saleModel->coin_code,
                ]));

                // PricingReference
                $pricingReference = $this->createElement('cac:PricingReference');
                $rootLine->appendChild($pricingReference);

                // PricingReference -> AlternativeConditionPrice
                $alternativeConditionPrice = $this->createElement('cac:AlternativeConditionPrice');
                $pricingReference->appendChild($alternativeConditionPrice);

                // PricingReference -> AlternativeConditionPrice -> PriceAmount
                $alternativeConditionPrice->appendChild($this->createElement('cbc:PriceAmount', $dt->price, [
                    'currencyID' => $saleModel->coin_code,
                ]));

                // PricingReference -> AlternativeConditionPrice -> PriceTypeCode
                $alternativeConditionPrice->appendChild($this->createElement('cbc:PriceTypeCode', $dt->price_type_code, [
                    'listAgencyName' => 'PE:SUNAT',
                    'listName' => 'Tipo de Precio',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16',
                ]));

                // TaxTotal
                $totalTaxeDtIgv = $this->createElement('cac:TaxTotal');
                $rootLine->appendChild($totalTaxeDtIgv);

                // TaxTotal -> TaxAmount
                $totalTaxeDtIgv->appendChild($this->createElement('cbc:TaxAmount', $dt->igv, [
                    'currencyID' => $saleModel->coin_code
                ]));

                // TaxTotal -> TaxSubtotal
                $taxSubtotalParamsDt = new TaxSubtotalParams();
                $taxSubtotalParamsDt->coin_code = $saleModel->coin_code;
                $taxSubtotalParamsDt->total = $dt->total_value;
                $taxSubtotalParamsDt->igv = $dt->igv;
                $taxSubtotalParamsDt->percentage = $productModel->affectTypeModel->percentage;
                $taxSubtotalParamsDt->code = $productModel->affectTypeModel->code;
                $taxSubtotalParamsDt->tribute_code = $productModel->affectTypeModel->tribute_code;
                $taxSubtotalParamsDt->tribute_name = $productModel->affectTypeModel->tribute_name;
                $taxSubtotalParamsDt->tribute_type = $productModel->affectTypeModel->tribute_type;
                $totalTaxeDtIgv->appendChild($this->createElementTaxSubtotal($taxSubtotalParamsDt));

                // Item
                $rootLine->appendChild($this->createElementItem(
                    $productModel->description,
                    $productModel->code
                ));

                // Price
                $price = $this->createElement('cac:Price');
                $rootLine->appendChild($price);

                // Price -> PriceAmount
                $price->appendChild($this->createElement('cbc:PriceAmount', $dt->unit_value, [
                    'currencyID' => $saleModel->coin_code
                ]));
            }

            $this->doc->save($xmlPath);

            return new OperationResult(true);
        } catch (Exception $ex) {
            return $this->utilService->reponseError("Error en genera el XML ({$ex->getMessage()})");
        }
    }

    public function guide(GuidesModel $guidesModel, string $xmlPath): OperationResult
    {
        try {
            $this->resetDocument();
            $branchModel = $guidesModel->branchModel;
            $emitterModel = $branchModel->emitterModel;
            $clientModel = $guidesModel->clientModel;
            $reasonTransferModel = $guidesModel->reasonTransferModel;
            $transportTypeModel = $guidesModel->transportTypeModel;
            $carrierModel = $guidesModel->carrierModel;
            $driveModel = $guidesModel->driveModel;

            $config = $this->getSaleXmlConfig($guidesModel->voucher_type_code);
            $rootElement = $config['root'];

            /*
            |--------------------------------------------------------------------------
            | ROOT
            |--------------------------------------------------------------------------
            */
            $root = $this->createElementRoot($rootElement);
            $this->doc->appendChild($root);

            /*
            |--------------------------------------------------------------------------
            | UBL EXTENSIONS FIRMA
            |--------------------------------------------------------------------------
            */
            $root->appendChild($this->createElementUblExtensions());

            /*
            |--------------------------------------------------------------------------
            | VERSIÓN
            |--------------------------------------------------------------------------
            */
            $root->appendChild($this->createElement('cbc:UBLVersionID', $this->UBLVersionID));
            $root->appendChild($this->createElement('cbc:CustomizationID', $this->CustomizationID));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL COMPROBANTE
            |--------------------------------------------------------------------------
            */
            $root->appendChild($this->createElement('cbc:ID', "{$guidesModel->serie}-{$guidesModel->correlative}"));
            $root->appendChild($this->createElement('cbc:IssueDate', $guidesModel->issue_date));
            $root->appendChild($this->createElement('cbc:IssueTime', $guidesModel->hour));
            $root->appendChild($this->createElement('cbc:DespatchAdviceTypeCode', $guidesModel->voucher_type_code));

            if (!empty($guidesModel->observation)) {
                $root->appendChild($this->createElement('cbc:Note', "Obs: {$guidesModel->observation}"));
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL LAS VENTAS RELACIONAS A LA GUÍA
            |--------------------------------------------------------------------------
            */
            /** @var SaleModel $sale */
            foreach ($guidesModel->guide_sales as $sale) {
                // AdditionalDocumentReference
                $additionalDocumentReference = $this->createElement('cac:AdditionalDocumentReference');
                $root->appendChild($additionalDocumentReference);

                // AdditionalDocumentReference -> ID
                $additionalDocumentReference->appendChild($this->createElement('cbc:ID', "{$sale->serie}-{$sale->correlative}"));

                // AdditionalDocumentReference -> DocumentTypeCode
                $additionalDocumentReference->appendChild($this->createElement('cbc:DocumentTypeCode', $sale->voucher_type_code, [
                    'listAgencyName' => 'PE:SUNAT',
                    'listName' => 'Tipo de Documento',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01',
                ]));

                // AdditionalDocumentReference -> DocumentType
                $relatedSaleDescription = match ($sale->voucher_type_code) {
                    '01' => 'FACTURA',
                    '03' => 'BOLETA',
                    default => 'OTROS'
                };
                $additionalDocumentReference->appendChild($this->createElement('cbc:DocumentType', $relatedSaleDescription));

                // AdditionalDocumentReference -> IssuerParty
                $issuerParty = $this->createElement('cac:IssuerParty');
                $additionalDocumentReference->appendChild($issuerParty);

                // AdditionalDocumentReference -> IssuerParty -> PartyIdentification
                $partyIdentification = $this->createElement('cac:PartyIdentification');
                $issuerParty->appendChild($partyIdentification);

                // AdditionalDocumentReference -> IssuerParty -> PartyIdentification -> ID
                $partyIdentification->appendChild($this->createElement('cbc:ID', $emitterModel->document, [
                    'schemeID' => $emitterModel->document_type,
                    'schemeAgencyName' => 'PE:SUNAT',
                    'schemeName' => 'Documento de Identidad',
                    'schemeURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06"',
                ]));
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL EMISOR
            |--------------------------------------------------------------------------
            */
            $signature = $this->createElementSignature($emitterModel);
            $root->appendChild($signature);

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL PROVEEDOR DE DESPACHO
            |--------------------------------------------------------------------------
            */
            // DespatchSupplierParty
            $despatchSupplierParty = $this->createElement('cac:DespatchSupplierParty');
            $root->appendChild($despatchSupplierParty);

            // DespatchSupplierParty -> CustomerAssignedAccountID
            $despatchSupplierParty->appendChild($this->createElement('cbc:CustomerAssignedAccountID', $emitterModel->document, [
                'schemeID' => $emitterModel->document_type,
            ]));

            // DespatchSupplierParty -> Party
            $partyParamsSupplier = new PartyParams();
            $partyParamsSupplier->document_type = $emitterModel->document_type;
            $partyParamsSupplier->document = $emitterModel->document;
            $partyParamsSupplier->company_name = $emitterModel->company_name;
            $despatchSupplierParty->appendChild($this->createElementParty($partyParamsSupplier));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL CLIENTE
            |--------------------------------------------------------------------------
            */
            $deliveryCustomerParty = $this->createElement('cac:DeliveryCustomerParty');
            $root->appendChild($deliveryCustomerParty);

            // DeliveryCustomerParty -> Party
            $partyParamsClient = clone $partyParamsSupplier;
            $excludedReasons = ['02', '04', '07', '18'];

            if (!in_array($reasonTransferModel->code, $excludedReasons, true)) {
                $partyParamsClient->document_type = $clientModel->document_type;
                $partyParamsClient->document = $clientModel->document;
                $partyParamsClient->company_name = $clientModel->company_name;
            }

            $deliveryCustomerParty->appendChild($this->createElementParty($partyParamsClient));

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL ENVIO
            |--------------------------------------------------------------------------
            */
            $shipment = $this->createElement('cac:Shipment');
            $root->appendChild($shipment);

            // Shipment -> ID
            $shipment->appendChild($this->createElement('cbc:ID', "SUNAT_Envio"));

            // Solo si es GUÍA DE REMISION REMITENTE
            if ($guidesModel->voucher_type_code === '09') {
                // Shipment -> HandlingCode
                $shipment->appendChild($this->createElement('cbc:HandlingCode', $reasonTransferModel->code, [
                    'listAgencyName' => 'PE:SUNAT',
                    'listName' => 'Motivo de traslado',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo20',
                ]));

                if ($reasonTransferModel->code === '13') {
                    // Shipment -> HandlingInstructions
                    $shipment->appendChild($this->createElement('cbc:HandlingInstructions', "OTROS - {$reasonTransferModel->descripcion}"));
                }
            }

            // Shipment -> GrossWeightMeasure
            $shipment->appendChild($this->createElement('cbc:GrossWeightMeasure', $guidesModel->weight, [
                'unitCode' => $guidesModel->unit_code
            ]));

            // Shipment -> SpecialInstructions
            $shipment->appendChild($this->createElement('cbc:SpecialInstructions', $guidesModel->sunat_indicator));

            // Shipment -> ShipmentStage
            $shipmentStage = $this->createElement('cac:ShipmentStage');
            $shipment->appendChild($shipmentStage);

            // Solo si es GUÍA DE REMISION REMITENTE
            if ($guidesModel->voucher_type_code === '09') {
                // Shipment -> ShipmentStage -> TransportModeCode
                $shipmentStage->appendChild($this->createElement('cbc:TransportModeCode', $transportTypeModel->code, [
                    'listName' => 'Motivo de traslado',
                    'listAgencyName' => 'PE:SUNAT',
                    'listURI' => 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo18',
                ]));
            }

            // Shipment -> ShipmentStage -> TransitPeriod
            $transitPeriod = $this->createElement('cac:TransitPeriod');
            $shipmentStage->appendChild($transitPeriod);

            // Shipment -> ShipmentStage -> TransitPeriod -> StartDate
            $transitPeriod->appendChild($this->createElement('cbc:StartDate', $guidesModel->transfer_date));

            // Solo si es tipo transporte publico
            if ($transportTypeModel->code === '01') {
                // Shipment -> ShipmentStage -> CarrierParty
                $carrierParty = $this->createElement('cac:CarrierParty');
                $shipmentStage->appendChild($carrierParty);

                // Shipment -> ShipmentStage -> CarrierParty -> PartyIdentification
                $partyIdentificationCarrie = $this->createElement('cac:PartyIdentification');
                $carrierParty->appendChild($partyIdentificationCarrie);

                // Shipment -> ShipmentStage -> CarrierParty -> PartyIdentification -> ID
                $partyIdentificationCarrie->appendChild($this->createElement('cbc:ID', $carrierModel->document, [
                    'schemeID' => $carrierModel->document_type
                ]));

                // Shipment -> ShipmentStage -> CarrierParty -> PartyLegalEntity
                $partyLegalEntityCarrie = $this->createElement('cac:PartyLegalEntity');
                $carrierParty->appendChild($partyLegalEntityCarrie);

                // Shipment -> ShipmentStage -> CarrierParty -> PartyLegalEntity -> RegistrationName
                $partyLegalEntityCarrie->appendChild($this->createElement('cbc:RegistrationName', $carrierModel->company_name));

                if (!empty($carrierModel->mtc_registry)) {
                    $partyLegalEntityCarrie->appendChild($this->createElement('cbc:CompanyID', $carrierModel->mtc_registry, [
                        'schemeID' => '06',
                        'schemeName' => 'Entidad Autorizadora',
                        'schemeAgencyName' => 'PE:SUNAT',
                    ]));
                }
            }

            // Solo si es tipo transporte privado
            if ($transportTypeModel->code === '02') {
                // Shipment -> ShipmentStage -> TransportMeans
                $transportMeans = $this->createElement('cac:TransportMeans');
                $shipmentStage->appendChild($transportMeans);

                // Shipment -> ShipmentStage -> TransportMeans -> RoadTransport
                $roadTransport = $this->createElement('cac:RoadTransport');
                $transportMeans->appendChild($roadTransport);

                // Shipment -> ShipmentStage -> TransportMeans -> RoadTransport -> LicensePlateID
                $roadTransport->appendChild($this->createElement('cbc:LicensePlateID', $guidesModel->guide_plates[0]->plate));

                // Shipment -> ShipmentStage -> DriverPerson
                $driverPerson = $this->createElement('cac:DriverPerson');
                $shipmentStage->appendChild($driverPerson);
                $isM1L = $guidesModel->sunat_indicator === 'SUNAT_Envio_IndicadorTrasladoVehiculoM1L';

                // Shipment -> ShipmentStage -> DriverPerson -> ID
                $driverPerson->appendChild($this->createElement(
                    'cbc:ID',
                    $isM1L ? null : $driveModel->document,
                    ['schemeID' => $isM1L ? '' : $driveModel->document_type]
                ));

                // Shipment -> ShipmentStage -> DriverPerson -> FirstName
                $driverPerson->appendChild($this->createElement('cbc:FirstName', $isM1L ? null : $driveModel->names));

                // Shipment -> ShipmentStage -> DriverPerson -> FamilyName
                $driverPerson->appendChild($this->createElement('cbc:FamilyName', $isM1L ? null : $driveModel->last_names));

                // Shipment -> ShipmentStage -> DriverPerson -> JobTitle
                $driverPerson->appendChild($this->createElement('cbc:JobTitle', 'Principal'));

                // Shipment -> ShipmentStage -> DriverPerson -> IdentityDocumentReference
                $identityDocumentReference = $this->createElement('cac:IdentityDocumentReference');
                $driverPerson->appendChild($identityDocumentReference);

                $identityDocumentReference->appendChild($this->createElement('cbc:ID', $isM1L ? null : $driveModel->driver_license));
            }

            // Shipment -> Delivery
            $delivery = $this->createElement('cac:Delivery');
            $shipment->appendChild($delivery);

            $adressTypeCode = $this->createElement('cbc:AddressTypeCode', $branchModel->local_code, [
                'listID' => $emitterModel->document,
                'listAgencyName' => 'PE:SUNAT',
                'listName' => 'Establecimientos anexos',
            ]);

            // Shipment -> Delivery -> DeliveryAddress
            $deliveryAddress = $this->createElement('cac:DeliveryAddress');
            $delivery->appendChild($deliveryAddress);

            // Shipment -> Delivery -> DeliveryAddress -> ID
            $deliveryAddress->appendChild($this->createElement('cbc:ID', $guidesModel->destination_ubigeo->code, [
                'schemeAgencyName' => 'PE:INEI',
                'schemeName' => 'Ubigeos',
            ]));

            if ($reasonTransferModel->code === '04') {
                // Shipment -> Delivery -> DeliveryAddress -> AddressTypeCode
                $deliveryAddress->appendChild($adressTypeCode);
            }

            // Shipment -> Delivery -> DeliveryAddress -> AddressLine
            $addressLineDelivery = $this->createElement('cac:AddressLine');
            $deliveryAddress->appendChild($addressLineDelivery);

            // Shipment -> Delivery -> DeliveryAddress -> AddressLine -> Line
            $addressLineDelivery->appendChild($this->createElement('cbc:Line', $guidesModel->destination_ubigeo->address));

            // Shipment -> Delivery -> Despatch
            $despatch = $this->createElement('cac:Despatch');
            $delivery->appendChild($despatch);

            // Shipment -> Delivery -> Despatch -> DespatchAddress
            $despatchAddress = $this->createElement('cac:DespatchAddress');
            $despatch->appendChild($despatchAddress);

            // Shipment -> Delivery -> Despatch -> DespatchAddress -> ID
            $despatchAddress->appendChild($this->createElement('cbc:ID', $guidesModel->origin_ubigeo->code, [
                'schemeAgencyName' => 'PE:INEI',
                'schemeName' => 'Ubigeos',
            ]));

            if ($reasonTransferModel->code === '04' || $reasonTransferModel->code === '18') {
                // Shipment -> Delivery -> Despatch -> DespatchAddress -> AddressTypeCode
                $despatchAddress->appendChild($adressTypeCode);
            }

            // Shipment -> Delivery -> Despatch -> DespatchAddress -> AddressLine
            $addressLineDespatch = $this->createElement('cac:AddressLine');
            $despatchAddress->appendChild($addressLineDespatch);

            // Shipment -> Delivery -> Despatch -> DespatchAddress -> AddressLine -> Line
            $addressLineDespatch->appendChild($this->createElement('cbc:Line', $guidesModel->origin_ubigeo->address));

            if ($guidesModel->voucher_type_code === '31') {
                // Shipment -> Delivery -> Despatch -> DespatchParty
                $despatchParty = $this->createElement('cac:DespatchParty');
                $despatch->appendChild($despatchParty);

                // Shipment -> Delivery -> Despatch -> DespatchParty -> PartyIdentification
                $partyIdentificationDespatch = $this->createElement('cac:PartyIdentification');
                $despatchParty->appendChild($partyIdentificationDespatch);

                // Shipment -> Delivery -> Despatch -> DespatchParty -> PartyIdentification -> ID
                $partyIdentificationDespatch->appendChild($this->createElement('cbc:ID', $clientModel->document, [
                    'schemeID' => $clientModel->document_type
                ]));

                // Shipment -> Delivery -> Despatch -> DespatchParty -> PartyLegalEntity
                $partyLegalEntityDespatch = $this->createElement('cac:PartyLegalEntity');
                $despatchParty->appendChild($partyLegalEntityDespatch);

                // Shipment -> Delivery -> Despatch -> DespatchParty -> PartyLegalEntity -> RegistrationName
                $partyLegalEntityDespatch->appendChild($this->createElement('cbc:RegistrationName', $clientModel->company_name));
            }

            if ($transportTypeModel->code === '02') {
                // Shipment -> TransportHandlingUnit
                $transportHandlingUnit = $this->createElement('cac:TransportHandlingUnit');
                $shipment->appendChild($transportHandlingUnit);

                // Shipment -> TransportHandlingUnit -> TransportEquipment
                $transportEquipment = $this->createElement('cac:TransportEquipment');
                $transportHandlingUnit->appendChild($transportEquipment);

                // Shipment -> TransportHandlingUnit -> TransportEquipment -> ID
                $transportEquipment->appendChild($this->createElement('cbc:ID', $guidesModel->guide_plates[0]->plate));

                /** @var GuidePlateModel $pla */
                foreach ($guidesModel->guide_plates as $key => $pla) {
                    if ($key === 0) continue;

                    // Shipment -> TransportHandlingUnit -> TransportEquipment -> AttachedTransportEquipment
                    $attachedTransportEquipment = $this->createElement('cac:AttachedTransportEquipment');
                    $transportEquipment->appendChild($attachedTransportEquipment);

                    // Shipment -> TransportHandlingUnit -> TransportEquipment -> AttachedTransportEquipment -> ID
                    $attachedTransportEquipment->appendChild($this->createElement('cbc:ID', $pla->plate));
                }
            }

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN DEL DETALLE PRODUCTO
            |--------------------------------------------------------------------------
            */
            /** @var GuideDetailModel $dt */
            foreach ($guidesModel->guide_details as $dt) {
                $productModel = $dt->productModel;
                $rootLine = $this->createElement("cac:DespatchLine");
                $root->appendChild($rootLine);

                // DespatchLine -> ID
                $rootLine->appendChild($this->createElement('cbc:ID', $dt->item));

                // DespatchLine -> DeliveredQuantity
                $rootLine->appendChild($this->createElement("cbc:DeliveredQuantity", $dt->amout, [
                    'unitCode' => $productModel->unit_code,
                    'unitCodeListID' => 'UN/ECE rec 20',
                    'unitCodeListAgencyName' => 'United Nations Economic Commission for Europe',
                ]));

                // DespatchLine -> DeliveredQuantity -> OrderLineReference
                $orderLineReference = $this->createElement('cac:OrderLineReference');
                $rootLine->appendChild($orderLineReference);

                // DespatchLine -> DeliveredQuantity -> OrderLineReference -> LineID
                $orderLineReference->appendChild($this->createElement('cbc:LineID', $dt->item));

                // Item
                $rootLine->appendChild($this->createElementItem(
                    $productModel->description,
                    $productModel->code
                ));
            }

            $this->doc->save($xmlPath);

            return new OperationResult(true);
        } catch (Exception $ex) {
            return $this->utilService->reponseError("Error en genera el XML ({$ex->getMessage()})");
        }
    }
}
