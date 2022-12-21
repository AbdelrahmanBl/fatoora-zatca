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
    public function handle(string $filename): string
    {
        return file_get_contents(__DIR__ . "/../xml/{$filename}.xml");
        // return file_get_contents(public_path("xml/{$filename}.xml"));
    }
}
