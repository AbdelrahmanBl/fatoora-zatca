<?php

namespace Bl\FatooraZatca\Invoices;

use Bl\FatooraZatca\Contracts\InvoiceContract;
use Bl\FatooraZatca\Objects\Client;
use Bl\FatooraZatca\Objects\Invoice;
use Bl\FatooraZatca\Objects\Seller;
use Bl\FatooraZatca\Zatca;

class B2C extends Invoiceable implements InvoiceContract
{
    protected $seller;

    protected $invoice;

    protected $client;

    public function __construct(Seller $seller, Invoice $invoice, Client $client = null)
    {
        $this->seller = $seller;
        $this->invoice = $invoice;
        $this->client = $client;
    }

    public static function make(Seller $seller, Invoice $invoice, Client $client = null): self
    {
        return new self($seller, $invoice, $client);
    }

    public function report(): self
    {
        $this->setResult(Zatca::reportSimplifiedInvoice($this->seller, $this->invoice, $this->client));
        return $this;
    }

    public function calculate(): self
    {
        $this->setResult(Zatca::calculateSimplifiedInvoice($this->seller, $this->invoice, $this->client));
        return $this;
    }
}
