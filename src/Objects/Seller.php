<?php

namespace Bl\FatooraZatca\Objects;

class Seller
{
    public $registration_number;

    public $street_name;

    public $building_number;

    public $plot_identification;

    public $city_sub_division;

    public $city;

    public $country;

    public $postal_number;

    public $tax_number;

    public $registration_name;

    public $private_key;

    public $certificate;

    public $secret;

    public function __construct(
        string $registration_number,
        string $street_name,
        string $building_number,
        string $plot_identification,
        string $city_sub_division,
        string $city,
        string $postal_number,
        string $tax_number,
        string $registration_name,
        string $private_key,
        string $certificate,
        string $secret,
        string $country = 'SA'
    )
    {
        $this->registration_number          = $registration_number;
        $this->street_name                  = $street_name;
        $this->building_number              = $building_number;
        $this->plot_identification          = $plot_identification;
        $this->city_sub_division            = $city_sub_division;
        $this->city                         = $city;
        $this->country                      = $country;
        $this->postal_number                = $postal_number;
        $this->tax_number                   = $tax_number;
        $this->registration_name            = $registration_name;
        $this->private_key                  = $private_key;
        $this->certificate                  = $certificate;
        $this->secret                       = $secret;
    }
}
