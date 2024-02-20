<?php

namespace Bl\FatooraZatca\Invoices;

use Bl\FatooraZatca\Actions\GetQrFromInvoice;

class Invoiceable
{
    private $result;

    public function setResult($result): void
    {
        $this->result = $result;
    }

    public function getClearedInvoice(): string
    {
        return $this->result['clearedInvoice'];
    }

    public function getInvoiceHash(): string
    {
        return $this->result['invoiceHash'];
    }

    public function getQr(): string
    {
        return (new GetQrFromInvoice)->handle($this->getClearedInvoice());
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
