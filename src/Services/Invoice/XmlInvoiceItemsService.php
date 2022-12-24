<?php

namespace Bl\FatooraZatca\Services\Invoice;

use Bl\FatooraZatca\Actions\GetXmlFileAction;
use Bl\FatooraZatca\Helpers\InvoiceHelper;
use Bl\FatooraZatca\Objects\InvoiceItem;
use Bl\FatooraZatca\Transformers\PriceFormat;

class XmlInvoiceItemsService
{
    /**
     * the invoice data.
     *
     * @var object
     */
    protected $invoice;

    /**
     * the invoice items.
     *
     * @var array
     */
    protected $invoiceItems;

    /**
     * __construct
     *
     * @param  object $invoice
     * @return void
     */
    public function __construct(object $invoice)
    {
        $this->invoice      = $invoice;

        $this->invoiceItems = $invoice->invoice_items;
    }

    /**
     * generate the xml of invoice items.
     *
     * @param  string $invoice_content
     * @return void
     */
    public function generate(string &$invoice_content): void
    {
        $invoice_content = str_replace('SET_TAX_TOTALS', $this->getTaxTotalXmlContent(), $invoice_content);

        // ? total tax of invoice itself.
        $invoice_content = str_replace(
            'TOTAL_TAX_AMOUNT',
            (new PriceFormat)->transform($this->invoice->total),
            $invoice_content
        );

        // <cac:LegalMonetaryTotal>
        $invoice_content = str_replace(
            'SET_LINE_EXTENSION_AMOUNT',
            (new PriceFormat)->transform($this->invoice->total - $this->invoice->tax),
            $invoice_content
        );
        $invoice_content = str_replace(
            'SET_NET_TOTAL',
            (new PriceFormat)->transform($this->invoice->total),
            $invoice_content
        );

        // TODO : handle multiple taxes & discounts. (must edit invoice_items).
        $invoice_content = str_replace('SET_INVOICE_LINES', $this->getInvoiceLineXmlContent(), $invoice_content);
    }

    /**
     * get the tax total xml content.
     *
     * @return string
     */
    protected function getTaxTotalXmlContent(): string
    {
        $xml = (new GetXmlFileAction)->handle('xml_tax_totals');

        $totalTax = (new PriceFormat)->transform($this->invoice->tax);

        $xml = str_replace("SET_TAX_AMOUNT", $totalTax, $xml);

        $xml = str_replace("SET_TAX_LINES", $this->getTaxSubtotalXmlContent(), $xml);

        return $xml;
    }

    /**
     * get the tax subtotal items xml content.
     *
     * @return string
     */
    protected function getTaxSubtotalXmlContent(): string
    {
        $taxSubtotalXml = '';

        foreach($this->invoiceItems as $item) {

            $taxSubtotalXmlItem = (new GetXmlFileAction)->handle('xml_tax_line');

            $itemSubTotal = (new InvoiceHelper)->calculateSubTotal($item);

            $taxSubtotalXmlItem = str_replace(
                'ITEM_SUB_TOTAL',
                (new PriceFormat)->transform($itemSubTotal),
                $taxSubtotalXmlItem
            );

            $taxSubtotalXmlItem = str_replace(
                    'ITEM_TOTAL_TAX',
                    (new PriceFormat)->transform($item->tax),
                    $taxSubtotalXmlItem
            );

            $taxSubtotalXmlItem = str_replace(
                'SET_TAX_VALUE',
                (new PriceFormat)->transform($item->tax_percent),
                $taxSubtotalXmlItem
            );

            $taxSubtotalXml .= $taxSubtotalXmlItem . '\n';

        }

        $taxSubtotalXml = rtrim($taxSubtotalXml, '\n');

        return $taxSubtotalXml;
    }

    /**
     * get the invoice lines xml content.
     *
     * @return string
     */
    protected function getInvoiceLineXmlContent(): string
    {
        $invoiceLineXml = '';

        foreach($this->invoiceItems as $index => $item) {

            $xml = (new GetXmlFileAction)->handle('xml_line_item');

            $xml = str_replace('ITEM_ID', $item->id, $xml);

            $xml = str_replace('ITEM_QTY', $item->quantity, $xml);

            $xml = str_replace('ITEM_PRICE', $item->price, $xml);

            $xml = str_replace('ITEM_NAME', $item->product_name, $xml);

            $itemSubTotal = (new InvoiceHelper)->calculateSubTotal($item);

            $xml = str_replace('ITEM_SUB_TOTAL', (new PriceFormat)->transform($itemSubTotal), $xml);

            $xml = str_replace('ITEM_TOTAL_TAX', (new PriceFormat)->transform($item->tax), $xml);

            $xml = str_replace('ITEM_TOTAL_INCLUDE_TAX', (new PriceFormat)->transform($item->total), $xml);

            $isLastItem = $index == count($this->invoiceItems);

            $xml = str_replace(
                'ITEM_TAX_CATEGORY',
                $this->getClassifiedTaxCategoryXmlContent($item, $isLastItem),
                $xml
            );
            $xml = str_replace(
                'ITEM_DISCOUNT',
                $this->getAllowanceChargeXmlContent($item, $isLastItem),
                $xml
            );

            $invoiceLineXml .= $xml . '\n';

        }

        $invoiceLineXml = rtrim($invoiceLineXml, '\n');

        return $invoiceLineXml;
    }

    /**
     * get the classified tax category xml content.
     *
     * @param  \Bl\FatooraZatca\Objects\InvoiceItem    $item
     * @param  bool     $new_line
     * @return string
     */
    protected function getClassifiedTaxCategoryXmlContent(InvoiceItem $item, bool $new_line): string
    {
        $xml = (new GetXmlFileAction)->handle('xml_line_item_tax_category');

        $xml = str_replace(
            'PERCENT_VALUE',
            (new PriceFormat)->transform($item->tax_percent),
            $xml
        );

        $xml .= $new_line ? '\n' : '';

        return $xml;
    }

    /**
     * get the discount items xml content.
     *
     * @param  \Bl\FatooraZatca\Objects\InvoiceItem    $item
     * @param  bool     $new_line
     * @return string
     */
    protected function getAllowanceChargeXmlContent(InvoiceItem $item, bool $new_line): string
    {
            $xml    = (new GetXmlFileAction)->handle('xml_line_item_discount');

            $xml    = str_replace(
                'DISCOUNT_VALUE',
                (new PriceFormat)->transform($item->discount),
                $xml
            );

            $xml    = str_replace('DISCOUNT_REASON', $item->discount_reason ?? 'Discount', $xml);

            $xml   .= $new_line ? '\n' : '';

        return $xml;
    }


}
