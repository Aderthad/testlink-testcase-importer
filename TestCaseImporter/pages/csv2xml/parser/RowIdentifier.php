<?php
include_once(__DIR__."/../elements/ElementTypes.php");
include_once(__DIR__."/CsvColumns.php");

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This helper class is responsible for identifying current template row.
 */
class RowIdentifier {    
    
    /**
     * This functions returns the element type of a row based on first non-empty column.
     * @param array $row template row
     * @return one of tree ElementTypes (TEST_SUITE, TEST_CASE, STEPS) or null
     */
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
