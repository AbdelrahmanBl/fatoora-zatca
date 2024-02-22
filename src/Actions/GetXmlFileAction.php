<?php

namespace Bl\FatooraZatca\Actions;

class GetXmlFileAction
{
    /**
     * handle get content of xml file.
     *
     * @param  string $filename
     * @return string
     */
    public static function handle(string $filename): string
    {
        return file_get_contents(__DIR__ . "/../Xml/{$filename}.xml");
        // return file_get_contents(public_path("Xml/{$filename}.xml"));
    }
}
