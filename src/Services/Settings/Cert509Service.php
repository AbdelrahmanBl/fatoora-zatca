<?php

namespace Bl\FatooraZatca\Services\Settings;

use Bl\FatooraZatca\Actions\PostRequestAction;
use Bl\FatooraZatca\Helpers\ConfigHelper;

class Cert509Service
{
    /**
     * is in production mode.
     *
     * @var bool
     */
    protected $isProduction;

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
     * generate the certificate 509 & other data.
     *
     * @param  object $settings
     * @return void
     */
    public function generate(object &$settings): void
    {
        $this->isProduction = ConfigHelper::isProduction();

        if($this->isProduction) {

            $this->handleProductionMode($settings);

        }
        else {

            $this->handleComplianceMode($settings);

        }
    }

    /**
     * when production mode.
     *
     * @param  object $settings
     * @return void
     */
    public function handleProductionMode(object &$settings): void
    {
        $this->handleComplianceMode($settings);

        $this->setCert509('production', $settings);
    }

    /**
     * when test mode.
     *
     * @param  object $settings
     * @return void
     */
    public function handleComplianceMode(object &$settings): void
    {
        $this->setCert509('compliance', $settings);
    }

    /**
     * set certificate 509 data.
     *
     * @param  string $type     production|compliance
     * @param  object $settings
     * @return array
     */
    protected function setCert509(string $type, object &$settings): void
    {
        $data       = $this->getPostData($type, $settings);

        $headers    = $this->getHeaders();

        $route      = $this->getRoute($type);

        $USERPWD    = $this->getUSERPWD($type, $settings);

        $response   = (new PostRequestAction)->handle($route, $data, $headers, $USERPWD);

        $settings->{"cert_{$type}"}     = $response['binarySecurityToken'];

        $settings->{"secret_{$type}"}   = $response['secret'];

        $settings->{"csid_id_{$type}"}  = $response['requestID'];
    }

    /**
     * get post data of request.
     *
     * @param  string $type     production|compliance
     * @param  object $settings
     * @return array
     */
    protected function getPostData(string $type, object $settings): array
    {
        if($type == 'production') {

            return [
                'compliance_request_id' => $settings->csid_id_compliance
            ];

        }

        return [
            'csr' => $settings->csr
        ];
    }

    /**
     * get headers of request.
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            'accept: application/json',
            'Content-Type: application/json',
            'otp: ' . $this->data->otp,
            'Accept-Version: V2'
        ];
    }

    /**
     * get route of request.
     *
     * @param  string $type
     * @return string
     */
    protected function getRoute(string $type): string
    {
        return ($type == 'production') ? '/production/csids' : '/compliance';
    }

    /**
     * get user & password for authentication.
     *
     * @param  mixed $type
     * @param  mixed $settings
     * @return string
     */
    protected function getUSERPWD(string $type, object $settings): string
    {
        $USERPWD = '';

        if($type == 'production') {

            $USERPWD = $settings->cert_compliance. ":" . $settings->secret_compliance;

        }

        return $USERPWD;
    }
}
