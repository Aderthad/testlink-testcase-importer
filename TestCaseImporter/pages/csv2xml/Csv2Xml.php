<?php
/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class is responsible for creating a formatted XML string from csv array
 * that can be imported using TestLink's test suite import feature.
 */

include_once(__DIR__."/parser/Parser.php");

class Csv2Xml {
    // XML declaration constant
    const ENC_DEC = '<?xml version="1.1" encoding="UTF-8"?>';

    /**
     * This function creates an formatted XML string from csv array
     * that can be imported using TestLink's test suite import feature.
     * @param array $csv csv file in an array form
     * @return string test suite import xml
     */
    function createXmlFromCsv($csv) {
        $parser = new Parser();
        $xml = self::ENC_DEC;
        $xml .= $parser->parse($csv)->build();
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xml);
        $dom->formatOutput = TRUE;
        return $dom->saveXml();        
    }
}
