<?php

namespace Bl\FatooraZatca\Objects;

class Invoice
{
    public $id;

    /**
     * the serial number of invoice.
     *
     * @var string
     */
    public $invoice_number;

    public $invoice_billing_id;

    public $invoice_uuid;

    /**
     * invoice date in Y-m-d format.
     *
     * @var mixed
     */
    public $invoice_date;

    /**
     * invoice time in H:i:s format
     *
     * @var mixed
     */
    public $invoice_time;

    /**
     * the invoice type.
     * 388 Tax INVOICE
     * 383 DEBIT_NOTE (refund)
     * 381 CREDIT_NOTE
     *
     * @var int
     */
    public $invoice_type;

    /**
     * the payment types.
     * 10 CASH
     * 30 CREDIT
     * 42 BANK_ACCOUNT
     * 48 BANK_CARD
     * 1  MULTIPLE
     *
     * @var int
     */
    public $payment_type;

    /**
     * invoice note when invoice type is DEBIT_NOTE|CREDIT_NOTE.
     *
     * @var string
     */
    public $invoice_note;

    /**
     * payment note when multiple payment eg:cash,visa
     *
     * @var string
     */
    public $payment_note;

    public $currency;

    /**
     * previous hash of last invoice.
     *
     * @var string
     */
    public $previous_hash;

    public $price;

    public $discount;

    public $tax;

    public $total;

    public $tax_percent;

    public $delivery_date;

    /**
     * the invoice items.
     *
     * @var array<InvoiceItem>
     */
    public $invoice_items;

    public function __construct(
        int         $id,
        string      $invoice_number,
        string      $invoice_uuid,
        string      $invoice_date,
        string      $invoice_time,
        int         $invoice_type,
        int         $payment_type,
        float       $price,
        float       $discount,
        float       $tax,
        float       $total,
        array       $invoice_items,
        string      $previous_hash = null,
        int         $invoice_billing_id = null,
        string      $invoice_note = null,
        string      $payment_note = null,
        string      $currency = 'SAR',
        float       $tax_percent = 15,
        string      $delivery_date = NULL
    )
    {
        $this->id                       = $id;
        $this->invoice_number           = $invoice_number;
        $this->invoice_billing_id       = $invoice_billing_id;
        $this->invoice_uuid             = $invoice_uuid;
        $this->invoice_date             = $invoice_date;
        $this->invoice_time             = $invoice_time;
        $this->invoice_type             = $invoice_type;
        $this->payment_type             = $payment_type;
        $this->invoice_note             = $invoice_note;
        $this->payment_note             = $payment_note;
        $this->currency                 = $currency;
        $this->previous_hash            = $previous_hash;
        $this->price                    = $price;
        $this->discount                 = $discount;
        $this->tax                      = $tax;
        $this->total                    = $total;
        $this->invoice_items            = $invoice_items;
        $this->tax_percent              = $tax_percent;
        $this->delivery_date            = $delivery_date;
    }
}
