<?php

namespace Bl\FatooraZatca\Services\Settings;

use Exception;

class KeysService
{
    /**
     * the private key.
     *
     * @var string
     */
    protected $privateKey;

    /**
     * the public key.
     *
     * @var string
     */
    protected $publicKey;

    /**
     * the certificate request.
     *
     * @var string
     */
    protected $csr;

    /**
     * the configurations for generating the private key.
     *
     * @var array
     */
    protected $config;

    /**
     * the certificate request options.
     *
     * @var array
     */
    protected $csrOptions;

    /**
     * the temporary file of written cnf text.
     *
     * @var file
     */
    protected $tmp;

    /**
     * the data of a tax payer.
     *
     * @var object
     */
    protected $data;

    /**
     * cnf file in base64 format.
     *
     * @var string
     */
    protected $cnf;

    /**
     * __construct
     *
     * @param  object $data
     * @param  string $cnf
     * @return void
     */
    public function __construct(object $data, string $cnf)
    {
        $this->data = $data;

        $this->cnf  = $cnf;
    }

    /**
     * generate the private & public key.
     *
     * @return array
     */
    public function generate(): array
    {
        $this->setUpConig();

        $this->generateKeys();

        $this->generateCsr();

        $this->removeTmpFile();

        return [

            base64_encode($this->privateKey),

            base64_encode($this->publicKey),

            base64_encode($this->csr)

        ];
    }

    /**
     * set up configurations for generating the private key & csr.
     *
     * @return void
     */
    protected function setUpConig(): void
    {
        $this->tmp = tmpfile();

        fwrite($this->tmp, base64_decode($this->cnf));

        fseek($this->tmp, 0);

        $tmpFilePath = stream_get_meta_data($this->tmp)['uri'];

        // for generating the private & public key.
        $this->config = [
            "config"            => $tmpFilePath,
            'private_key_type'  => OPENSSL_KEYTYPE_EC,
            'curve_name'        => 'secp256k1'
        ];

        // for generating the certificate request.
        $this->csrOptions = [
            'digest_alg'        => 'sha256',
            "req_extensions"    => "req_ext",
            'curve_name'        => 'secp256k1',
            "config"            => $tmpFilePath,
        ];
    }

    /**
     * generate private & public key.
     *
     * @return void
     */
    protected function generateKeys(): void
    {
        $res = openssl_pkey_new($this->config);

        if (!$res) {

            throw new Exception('ERROR: Fail to generate private key. -> ' . openssl_error_string());

        }

        // generate private key proccess.
        openssl_pkey_export($res, $this->privateKey , NULL, $this->config);

        $keyDetails = openssl_pkey_get_details($res);

        // generate public key proccess.
        $this->publicKey = $keyDetails["key"];
    }

    /**
     * generate the certificate request.
     *
     * @return void
     */
    protected function generateCsr(): void
    {
        $dn = [
            "commonName"                => $this->data->commonName,
            "organizationalUnitName"    => $this->data->organizationalUnitName,
            "organizationName"          => $this->data->organizationName,
            "countryName"               => $this->data->countryName,
        ];

        $csr = openssl_csr_new($dn, $this->privateKey, $this->csrOptions);

        openssl_csr_export($csr, $csrString);

        $this->csr = $csrString;
    }

    /**
     * remove the temporary file of cnf text.
     *
     * @return void
     */
    protected function removeTmpFile(): void
    {
        fclose($this->tmp);
    }
}
