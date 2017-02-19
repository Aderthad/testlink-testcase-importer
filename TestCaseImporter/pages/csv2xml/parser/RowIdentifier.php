<?php
include_once(__DIR__."/../elements/ElementTypes.php");
class RowIdentifier {    
    static function identifyElementType($row){
        for ($index = 0; $index < count($row); $index++) {
            if(!empty($row[$index])) {
                return self::getElementTypeByColumn($index);
            }
        }
        return null;
    }
    
    private static function getElementTypeByColumn($column){
        switch ($column) {
            case CsvRows::TEST_SUITE_NAME_ROW: return ElementTypes::TEST_SUITE;                
            case CsvRows::TEST_CASE_NAME_ROW: return ElementTypes::TEST_CASE;                
            case CsvRows::STEP_ROW: return ElementTypes::STEPS;
            default: return null;
        }
    }
}
