<?php

namespace Bl\FatooraZatca\Actions;

class PostRequestAction
{
    /**
     * handle sending the request to zatca portal.
     *
     * @param  string   $route
     * @param  array    $data
     * @param  array    $headers
     * @param  string   $USERPWD
     * @return array
     */
    public function handle(string $route, array $data, array $headers, string $USERPWD): array
    {
        $portal = config('zatca.app.is_production') ? config('zatca.portals.production') : config('zatca.portals.local');

        $ch     = curl_init($portal . $route);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(strlen($USERPWD)) {
            curl_setopt($ch, CURLOPT_USERPWD,  $USERPWD);
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute!
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = json_decode($response,true);

        // close the connection, release resources used
        curl_close($ch);

        return (new HandleResponseAction)->handle($httpcode, $response);
    }
}
