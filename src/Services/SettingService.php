<?php

namespace Bl\FatooraZatca\Services;

use Bl\FatooraZatca\Services\Settings\Cert509Service;
use Bl\FatooraZatca\Services\Settings\CnfFileService;
use Bl\FatooraZatca\Services\Settings\KeysService;

class SettingService
{
    /**
     * the settings data of zatca.
     *
     * @var object
     */
    protected $settings;


    /**
     * the data of a tax payer.
     *
     * @var object
     */
    protected $data;

    /**
     * __construct
     *
     * @param  object $data
     * @return void
     */
    public function __construct(object $data)
    {
        $this->data = $data;
    }

    /**
     * generate cnf file.
     * generate csr request.
     * generate private key.
     * generate public key.
     *
     * @return object
     */
    public function generate(): object
    {
        $this->setUp();

        $this->generateCnfFile();

        $this->generateKeys();

        $this->generateCert509();

        return $this->settings;
    }

    /**
     * setUp settings data of tax payer for reporting|clearance invoices.
     *
     * @return void
     */
    protected function setUp(): void
    {
        if(! isset($this->settings)) {

            $this->settings = (object) [
                'cnf'                   => null, # the cnf file
                'private_key'           => null, # the private key
                'public_key'            => null, # the public key
                'csr'                   => null, # the certificate request
                'cert_production'       => null, # the certificate 509 production
                'secret_production'     => null, # the secret production
                'csid_id_production'    => null, # the csid id production
                'cert_compliance'       => null, # the certificate 509 compliance
                'secret_compliance'     => null, # the secret compliance
                'csid_id_compliance'    => null, # the csid id compliance
            ];

        }
    }

    /**
     * generate cnf file.
     *
     * @return void
     */
    protected function generateCnfFile(): void
    {
        $this->settings->cnf = (new CnfFileService($this->data))->generate();
    }

    /**
     * generate public & private key in base64 format.
     *
     * @return void
     */
    protected function generateKeys(): void
    {
        list(

            $this->settings->private_key,

            $this->settings->public_key,

            $this->settings->csr

        ) = (new KeysService($this->data, $this->settings->cnf))->generate();
    }

    /**
     * generate certificate 509 & it's data.
     *
     * @return void
     */
    protected function generateCert509(): void
    {
        (new Cert509Service($this->data))->generate($this->settings);
    }
}
