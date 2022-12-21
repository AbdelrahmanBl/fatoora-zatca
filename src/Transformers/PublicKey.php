<?php

namespace Bl\FatooraZatca\Transformers;

class PublicKey
{
    /**
     * eliminate the public key header & footer and get it in base64 format.
     *
     * @param  string $public_key
     * @return string
     */
    public function transform(string $public_key): string
    {
        $publicKey = str_replace('-----BEGIN PUBLIC KEY-----', '', $public_key);

        $publicKey = str_replace('-----END PUBLIC KEY-----', '', $publicKey);

        return base64_decode($publicKey);
    }
}
