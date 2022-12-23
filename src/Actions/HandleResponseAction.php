<?php

namespace Bl\FatooraZatca\Actions;

use Exception;

class HandleResponseAction
{
    /**
     * handle the response of zatca portal.
     *
     * @param  mixed $httpcode
     * @param  mixed $response
     * @return array
     */
    public function handle($httpcode, $response): array
    {
        if((int) $httpcode === 200) {

            return $response;

        }
        else if((int) $httpcode === 401) {

            throw new Exception('Unauthoroized zatca settings!');

        }
        else {

            if(is_array($response) && array_key_exists('code', $response)) {

                throw new Exception($response['message']);

            }
            else if(is_array($response) && array_key_exists('errors', $response)) {

                throw new Exception($response['errors'][0]);

            }
            else if(is_array($response) && array_key_exists('validationResults', $response)) {

                if(count($response['validationResults']['errorMessages']) > 0) {

                    throw new Exception($response['validationResults']['errorMessages'][0]['message']);

                }

                throw new Exception('Unhandeled validation rules exception!');

            }
            else {

                throw new Exception('Unhandeled zatca error exception!');

            }

        }
    }
}
