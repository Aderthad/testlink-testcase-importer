<?php
include_once(__DIR__."/CsvReader.php");
include_once(__DIR__."/CsvRows.php");
include_once(__DIR__."/RowIdentifier.php");
include_once(__DIR__."/../elements/Element.php");
include_once(__DIR__."/../elements/ElementTypes.php");
include_once(__DIR__."/../elements/TestCaseElement.php");
include_once(__DIR__."/../elements/TestSuiteElement.php");

class Parser {
    function parse($file) {
        $csv =  CsvReader::readCSV($file); 
        //remove column labels
        array_shift($csv);
        
        $parentTestSuite = new Element(ElementTypes::TEST_SUITE);
        $currentTestSuite = $parentTestSuite;
        $currentTestCase = null;
        
        foreach ($csv as $row) {
            $elementType = RowIdentifier::identifyElementType($row);
            
            if(ElementTypes::TEST_SUITE == $elementType){
                if(!empty($currentTestCase)) {
                    $currentTestSuite = $parentTestSuite;
                    $currentTestCase = null;
                }
                $existingSuite = $currentTestSuite->getChildElement($row[CsvRows::TEST_SUITE_NAME_ROW], ElementTypes::TEST_SUITE);
                if(empty($existingSuite)) {
                    $newTestSuite = new TestSuiteElement();
                    $newTestSuite->setName($row[CsvRows::TEST_SUITE_NAME_ROW]);                    
                    $newTestSuite->setDetail($row[CsvRows::TEST_SUITE_DETAILS_ROW]);
                    $currentTestSuite->addChildElement($newTestSuite);
                    $currentTestSuite = $newTestSuite;                    
                } else {         
                    $currentTestSuite = $existingSuite;
                }
            }
            
            if(ElementTypes::TEST_CASE == $elementType){
                $newTestCase = new TestCaseElement();
                $newTestCase->setName($row[CsvRows::TEST_CASE_NAME_ROW]);
                $newTestCase->setSummary($row[CsvRows::TEST_CASE_SUMMARY_ROW]);
                $newTestCase->setPreconditions($row[CsvRows::TEST_CASE_PRECONDITIONS_ROW]);
                $newTestCase->setExeType($row[CsvRows::TEST_CASE_EXE_TYPE_ROW]);
                $newTestCase->setImportance($row[CsvRows::TEST_CASE_IMPORTANCE]);
                $currentTestSuite->addChildElement($newTestCase);
                $this->handleStep($row, $newTestCase);                
                $currentTestCase = $newTestCase;
            }
            
            if(ElementTypes::STEPS == $elementType) {
                $this->handleStep($row, $currentTestCase);
            }
        }
        
        return $parentTestSuite;
    }
    
    private function handleStep($row, $testCase) {
        $testCase->addStep($row[CsvRows::STEP_ROW]);
        $testCase->addExpResult($row[CsvRows::EXP_RESULT_ROW]);
    }
}