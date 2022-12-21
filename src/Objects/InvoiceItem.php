<?php

namespace Bl\FatooraZatca\Objects;

class InvoiceItem
{
    public $id;

    public $product_name;

    public $quantity;

    public $price;

    public $discount;

    public $tax;

    public $tax_percent;

    public $total;

    public $discount_reason;

    public function __construct(
        int     $id,
        string  $product_name,
        int     $quantity,
        float   $price,
        float   $discount,
        float   $tax,
        float   $tax_percent,
        float   $total,
        string  $discount_reason = null
    )
    {
        $this->id                       = $id;
        $this->product_name             = $product_name;
        $this->quantity                 = $quantity;
        $this->price                    = $price;
        $this->discount                 = $discount;
        $this->tax                      = $tax;
        $this->tax_percent              = $tax_percent;
        $this->total                    = $total;
        $this->discount_reason          = $discount_reason;
    }
}
