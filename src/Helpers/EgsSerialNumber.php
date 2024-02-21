<?php

namespace Bl\FatooraZatca\Helpers;

class EgsSerialNumber
{
    public static function generate(): string
    {
        $egs  = [];

        for($i = 1; $i <= 3; $i++) {

            $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

            shuffle($seed);

            $randKeys = array_rand($seed, 3);

            $chars = '';

            foreach($randKeys as $key) {

                $chars .= $seed[$key];

            }

            $egs[] = "{$i}-{$chars}";
        }

        return implode('|', $egs);
    }
}
