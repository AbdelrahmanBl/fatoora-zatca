<?php

namespace Bl\FatooraZatca\Services\Invoice;

class TLVProtocolService
{
    /**
     * the generated tlv content.
     *
     * @var string
     */
    protected $tlv;

    /**
     * the data for generate tlv.
     *
     * @var array
     */
    protected $data;


    /**
     * __construct
     *
     * @param  array    $data
     * @param  int      $pahse
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data     = $data;

        $this->generate();
    }

    /**
     * get the tlv content in base64 format.
     *
     * @return string
     */
    public function toBase64Format(): string
    {
        return base64_encode($this->tlv);
    }

    /**
     * generate the tlv protocol.
     *
     * @return void
     */
    protected function generate(): void
    {
        foreach($this->data as $key => $value) {

            $tag    = $key + 1;

            $length = strlen($value);

            $this->tlv .= $this->__toHex($tag) . $this->__toHex($length) . ($value);

        }
    }

    /**
     * __toHex
     *
     * @param  string $value
     * @return string
     */
    protected function __toHex(string $value): string
    {
        return pack("H*", sprintf("%02X", $value));
    }
}
