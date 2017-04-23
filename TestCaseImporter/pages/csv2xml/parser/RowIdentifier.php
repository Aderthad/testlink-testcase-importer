<?php
include_once(__DIR__."/../elements/ElementTypes.php");
include_once(__DIR__."/CsvColumns.php");
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
            case CsvColumns::TEST_SUITE_NAME_COLUMN: return ElementTypes::TEST_SUITE;                
            case CsvColumns::TEST_CASE_NAME_COLUMN: return ElementTypes::TEST_CASE;                
            case CsvColumns::STEP_COLUMN: return ElementTypes::STEPS;
            default: return null;
        }
    }
}
