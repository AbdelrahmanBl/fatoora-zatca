<?php

namespace Bl\FatooraZatca;

use Bl\FatooraZatca\Classes\DocumentType;
use Bl\FatooraZatca\Objects\Client;
use Bl\FatooraZatca\Objects\Invoice;
use Bl\FatooraZatca\Objects\Seller;
use Bl\FatooraZatca\Objects\Setting;
use Bl\FatooraZatca\Services\ReportInvoiceService;
use Bl\FatooraZatca\Services\SettingService;

class Zatca
{
    /**
     * generate zatca setting.
     *
     * @param  \Bl\FatooraZatca\Objects\Setting $setting
     * @return object
     */
    public static function generateZatcaSetting(Setting $setting): object
    {
        return (new SettingService($setting))->generate();
    }

    /**
     * report standard invoice.
     *
     * @param  \Bl\FatooraZatca\Objects\Setting   $seller
     * @param  \Bl\FatooraZatca\Objects\Invoice   $invoice
     * @param  \Bl\FatooraZatca\Objects\Client    $client
     * @return array
     */
    public static function reportStandardInvoice(Seller $seller, Invoice $invoice, Client $client): array
    {
        return (new ReportInvoiceService($seller, $invoice, $client))->clearance();
    }

    /**
     * report simplified invoice.
     *
     * @param  \Bl\FatooraZatca\Objects\Setting   $seller
     * @param  \Bl\FatooraZatca\Objects\Invoice   $invoice
     * @param  \Bl\FatooraZatca\Objects\Client    $client
     * @return array
     */
    public static function reportSimplifiedInvoice(Seller $seller, Invoice $invoice, Client $client = null): array
    {
        return (new ReportInvoiceService($seller, $invoice, $client))->reporting();
    }

    /**
     * calculate simplified invoice.
     *
     * @param  \Bl\FatooraZatca\Objects\Setting   $seller
     * @param  \Bl\FatooraZatca\Objects\Invoice   $invoice
     * @param  \Bl\FatooraZatca\Objects\Client    $client
     * @return array
     */
    public static function calculateSimplifiedInvoice(Seller $seller, Invoice $invoice, Client $client = null): array
    {
        return (new ReportInvoiceService($seller, $invoice, $client))->calculate(DocumentType::SIMPILIFIED);
    }

    /**
     * report testing invoice.
     *
     * @param  \Bl\FatooraZatca\Objects\Setting   $seller
     * @param  \Bl\FatooraZatca\Objects\Invoice   $invoice
     * @param  \Bl\FatooraZatca\Objects\Client    $client
     * @return array
     */
    public static function reportTestingInvoice(Seller $seller, Invoice $invoice, Client $client = null): array
    {
        return (new ReportInvoiceService($seller, $invoice, $client))->test();
    }
}
