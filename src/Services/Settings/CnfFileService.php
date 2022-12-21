<?php

namespace Bl\FatooraZatca\Services\Settings;

class CnfFileService
{
    /**
     * cnf file in base64 format.
     *
     * @var string
     */
    protected $cnf;

    /**
     * certificate template name.
     *
     * @var string
     */
    protected $certificateTemplateName;

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
     * generate cnf file as base64 encode.
     *
     * @return string
     */
    public function generate(): string
    {
        $this->setCertificateTemplateName();

        $this->setCnfFileData();

        return base64_encode($this->cnf);
    }

    /**
     * set certificate template name.
     *
     * @return void
     */
    protected function setCertificateTemplateName(): void
    {
        $CTN = config('zatca.app.is_production') ? 'ZATCA' : 'TSTZATCA';

        $this->certificateTemplateName = "{$CTN}-Code-Signing";
    }

    /**
     * set cnf file as string.
     *
     * @return void
     */
    protected function setCnfFileData(): void
    {
        $this->cnf = "
        oid_section = OIDs
        [ OIDs ]
        certificateTemplateName= 1.3.6.1.4.1.311.20.2

        [ req ]
        default_bits 	= 2048
        emailAddress 	= {$this->data->emailAddress}
        req_extensions	= v3_req
        x509_extensions 	= v3_ca
        prompt = no
        default_md = sha256
        req_extensions = req_ext
        distinguished_name = dn

        [ v3_req ]
        basicConstraints = CA:FALSE
        keyUsage = digitalSignature, nonRepudiation, keyEncipherment

        [req_ext]
        certificateTemplateName = ASN1:PRINTABLESTRING:{$this->certificateTemplateName}
        subjectAltName = dirName:alt_names

        [ v3_ca ]


        # Extensions for a typical CA


        # PKIX recommendation.

        subjectKeyIdentifier=hash

        authorityKeyIdentifier=keyid:always,issuer:always
        [ dn ]
        CN ={$this->data->commonName}  				                        # Common Name
        C={$this->data->countryName}							            # Country Code e.g SA
        OU={$this->data->organizationalUnitName}							# Organization Unit Name
        O={$this->data->organizationName}							        # Organization Name

        [ alt_names ]
        SN={$this->data->egsSerialNumber}				                    # EGS Serial Number 1-ABC|2-PQR|3-XYZ
        UID={$this->data->taxNumber}						                # Organization Identifier (VAT Number)
        title={$this->data->invoiceType}								    # Invoice Type
        registeredAddress={$this->data->registeredAddress}  	 			# Address
        businessCategory={$this->data->businessCategory}					# Business Category";
    }
}
