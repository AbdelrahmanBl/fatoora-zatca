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

    public function getResult(): array
    {
        return $this->result;
    }

    public function getClearedInvoice(): string
    {
        return $this->getResult()['clearedInvoice'];
    }

    public function getInvoiceHash(): string
    {
        return $this->getResult()['invoiceHash'];
    }

    public function getQr(): string
    {
        return (new GetQrFromInvoice)->handle($this->getClearedInvoice());
    }

    public function getQrImage(): string
    {
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($this->getQr())->toHtml();
    }
}
