<?php
/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class is responsible for reading a csv file and returning its content
 * as an array.
 */

class CsvReader {
    
    const DELIMETER = ';';
    
    /**
     * This function returns an array of rows parsed from an input csv file
     * (where delimeter is a semi-colon)
     * @param string $path path to a file
     * @return array parsed csv file
     * @throws Exception if input file doesn't exist
     */
    static function readCSV($path){
        // check if given file exists
        if(!file_exists($path)) {
            // if not throw an exception
            throw new Exception("File not found: " . $path);
        }
        // create a new file object (read mode)
        $csv = new SplFileObject($path, "r");        
        // prepare an array that will be returned
        $return = array();
        // iterate through lines of the csv file
        // and add parsed rows to the array
        while(!$csv->eof()) {
            $row = $csv->fgetcsv(self::DELIMETER);            
            $return[] = $row;
        }
        // close the file object
        $csv = null;
        // return the array
        return $return;
    }
}