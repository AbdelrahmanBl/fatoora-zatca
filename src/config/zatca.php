<?php

return [

    /**
     * Zatca Phase 2
     *
     * we will consider some config data for zatca v2 in this file.
     * the mode of zatca app is by default the same as app environment.
     */
    'portals'       => [
        'local'         => 'https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal',
        'production'    => 'https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal',
    ],
    'app' => [
        'environment'   => env('ZATCA_ENVIRONMENT', env('APP_ENV', 'local')), # local|production
    ],


];
