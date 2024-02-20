<?php

namespace Bl\FatooraZatca\Contracts;

interface InvoiceContract
{
    public function report(): self;

    public function calculate(): self;
}
