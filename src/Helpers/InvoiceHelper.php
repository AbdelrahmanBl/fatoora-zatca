<?php

namespace Bl\FatooraZatca\Helpers;

use Bl\FatooraZatca\Objects\InvoiceItem;
use Carbon\Carbon;

class InvoiceHelper
{
    /**
     * calculate item sub total.
     *
     * @param  \Bl\FatooraZatca\Objects\InvoiceItem $item
     * @return float
     */
    public function calculateSubTotal(InvoiceItem $item): float
    {
        return $item->total - $item->tax;
        // return ($item['price'] * $item['quantity']) - $item['discount'];
    }

    /**
     * get the signing time.
     *
     * @param  object $invoice
     * @return string
     */
    public function getSigningTime(object $invoice): string
    {
        // TODO : must send the date of signing time when post simplified invoice.
        $timestamp = "{$invoice->invoice_date} {$invoice->invoice_time}";

        return Carbon::parse($timestamp)->toIso8601ZuluString();
    }

    /**
     * get the timestamp of invoice.
     *
     * @param  object $invoice
     * @return string
     */
    public function getTimestamp(object $invoice): string
    {
        $timestamp = "{$invoice->invoice_date} {$invoice->invoice_time}";

        return Carbon::parse($timestamp)->toDateTimeLocalString() . 'Z';
    }

    /**
     * get the hashed certificate in base64 format.
     * note : certificate parameter is in base64 format.
     *
     * @param  mixed $certificate
     * @return string
     */
    public function getHashedCertificate(string $certificate): string
    {
        $certificate = base64_decode($certificate);

        $certificate = hash('sha256', $certificate, false);

        return base64_encode($certificate);
    }

    /**
     * get hash signed properity in base64 format.
     *
     * @param  string $signed_properties
     * @return string
     */
    public function getHashSignedProperity(string $signed_properties): string
    {
        $signedProperties = unpack('H*', $signed_properties)['1'];

        $signedProperties = hash('sha256', $signedProperties, false);

        return base64_encode($signedProperties);
    }

    /**
     * get the certificate signature from certificate output.
     *
     * @param  mixed $certificate_output
     * @return string
     */
    public function getCertificateSignature(array $certificate_output): string
    {
        $signature = unpack('H*', $certificate_output['signature'])['1'];

        return pack('H*', substr($signature, 2));
    }
}
