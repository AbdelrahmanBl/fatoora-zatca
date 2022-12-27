<?php

namespace Bl\FatooraZatca\Objects;

class Setting
{
    public $otp;

    public $emailAddress;

    public $commonName;

    public $organizationalUnitName;

    public $organizationName;

    public $taxNumber;

    public $registeredAddress;

    public $businessCategory;

    public $egsSerialNumber;

    /**
     * the invoice type
     * 0100 for Simplified Tax Invoice|Simplified Debit Note|Simplified Credit Note
     * 1000 for Standard Tax Invoice|Standard Debit Note|Standard Credit Note.
     * 1100 for all six sample invoices.
     *
     * @var mixed
     */
    public $invoiceType;

    /**
     * the country is default SA.
     *
     * @var string
     */
    public $countryName;

    public function __construct(
        string $otp,
        string $emailAddress,
        string $commonName,
        string $organizationalUnitName,
        string $organizationName,
        string $taxNumber,
        string $registeredAddress,
        string $businessCategory,
        string $egsSerialNumber = NULL,
        string $invoiceType = '1100',
        string $countryName = 'SA'
    )
    {
        $this->otp                          = $otp;
        $this->emailAddress                 = $emailAddress;
        $this->commonName                   = $commonName;
        $this->organizationalUnitName       = $organizationalUnitName;
        $this->organizationName             = $organizationName;
        $this->taxNumber                    = $taxNumber;
        $this->registeredAddress            = $registeredAddress;
        $this->businessCategory             = $businessCategory;
        $this->egsSerialNumber              = $egsSerialNumber ?? $this->generateEgsSerialNumber();
        $this->invoiceType                  = $invoiceType;
        $this->countryName                  = $countryName;
    }

    /**
     * generate egs serial number.
     * 
     * @return string
     */
    public function generateEgsSerialNumber(): string
    {
        $egs  = [];

        for($i = 1; $i <= 3; $i++) {

            $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            
            shuffle($seed);
            
            $randKeys = array_rand($seed, 3);
            
            $chars = '';
            
            foreach($randKeys as $key) {

                $chars .= $seed[$key];
                
            }

            $egs[] = "{$i}-{$chars}";
        }

        return implode('|', $egs);
    }
}
