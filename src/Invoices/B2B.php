<?php

namespace Bl\FatooraZatca\Invoices;

use Bl\FatooraZatca\Zatca;
use Bl\FatooraZatca\Objects\Client;
use Bl\FatooraZatca\Objects\Seller;
use Bl\FatooraZatca\Objects\Invoice;
use Bl\FatooraZatca\Contracts\InvoiceContract;

class B2B extends Invoiceable implements InvoiceContract
{
    protected $seller;

    protected $invoice;

    protected $client;

    public function __construct(Seller $seller, Invoice $invoice, Client $client)
    {
        $this->seller = $seller;
        $this->invoice = $invoice;
        $this->client = $client;
    }

    public static function make(Seller $seller, Invoice $invoice, Client $client): self
    {
        return new self($seller, $invoice, $client);
    }

    public function report(): self
    {
        $this->setResult(Zatca::reportStandardInvoice($this->seller, $this->invoice, $this->client));
        return $this;
    }

    public function calculate(): self
    {
        return $this->report();
    }
}
