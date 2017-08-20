<?php
class CsvReader {    
    static function readCSV($path){        
        if(!file_exists($path)) {
            throw new Exception("File not found: " . $path);
        }
        $csv = new SplFileObject($path, "r");        
        $return = array();
        while(!$csv->eof()) {
            $row = $csv->fgetcsv(";");            
            array_push($return, $row);   
        }
        $csv = null;
        return $return;
    }
}