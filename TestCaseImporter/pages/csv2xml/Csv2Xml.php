<?php
include_once(__DIR__."/parser/Parser.php");

class Csv2Xml {
    private $enc_dec = '<?xml version="1.1" encoding="UTF-8"?>';

    function createXmlFromCsv($csv) {
        $parser = new Parser();
        $xml = $this->enc_dec;
        $xml .= $parser->parse($csv)->build();
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xml);
        $dom->formatOutput = TRUE;
        return $dom->saveXml();        
    }
}
