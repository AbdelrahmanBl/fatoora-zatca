<?php

namespace Bl\FatooraZatca\Objects;

class Client
{
    public $street_name;

    public $building_number;

    public $plot_identification;

    public $city_subdivision_name;

    public $city;

    public $country;

    public $postal_number;

    public $tax_number;

    public $registration_name;

    public function __construct(
        string $registration_name,
        string $tax_number,
        string $postal_number,
        string $street_name,
        string $building_number,
        string $plot_identification,
        string $city_subdivision_name,
        string $city,
        string $country = 'SA'
    )
    {
        $this->street_name              = $street_name;
        $this->building_number          = $building_number;
        $this->plot_identification      = $plot_identification;
        $this->city_subdivision_name    = $city_subdivision_name;
        $this->city                     = $city;
        $this->country                  = $country;
        $this->postal_number            = $postal_number;
        $this->tax_number               = $tax_number;
        $this->registration_name        = $registration_name;
    }
}
