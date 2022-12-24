<?php

namespace Bl\FatooraZatca\Actions;

class GetQrFromInvoice
{
    /**
     * handle getting the Qr in base64 format from xml signed invoice.
     *
     * @param  string $invoice
     * @return string
     */
    public function handle(string $invoice): string
    {
        $xmlString  = base64_decode($invoice);

        $element    = simplexml_load_string($xmlString);

        $element->registerXPathNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $element->registerXPathNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $result = $element->xpath('//cac:AdditionalDocumentReference[3]//cac:Attachment//cbc:EmbeddedDocumentBinaryObject')[0];

        return $result;
    }
}
