<?php
include_once(__DIR__."/CsvReader.php");
include_once(__DIR__."/CsvRows.php");
include_once(__DIR__."/RowIdentifier.php");
include_once(__DIR__."/../elements/Element.php");
include_once(__DIR__."/../elements/ElementTypes.php");
include_once(__DIR__."/../elements/TestCaseElement.php");
include_once(__DIR__."/../elements/TestSuiteElement.php");

class Parser {
    
    const KEYWORD_DELIMETER = ',';
    
    function parse($file) {
        $csv =  CsvReader::readCSV($file);
        
        //remove column headers
        $columnHeaders = array_shift($csv);
        
        $parentTestSuite = new TestSuiteElement();
        $currentTestSuite = $parentTestSuite;
        $currentTestCase = null;
        
        foreach ($csv as $row) {
            $elementType = RowIdentifier::identifyElementType($row);
            
            if(ElementTypes::TEST_SUITE == $elementType){
                if(!empty($currentTestCase)) {
                    $currentTestSuite = $parentTestSuite;
                    $currentTestCase = null;
                }
                $existingSuite = $currentTestSuite->getChildElement($row[CsvColumns::TEST_SUITE_NAME_COLUMN], ElementTypes::TEST_SUITE);
                if(empty($existingSuite)) {
                    $newTestSuite = new TestSuiteElement();
                    $newTestSuite->setName($row[CsvColumns::TEST_SUITE_NAME_COLUMN]);                    
                    $newTestSuite->setDetail($row[CsvColumns::TEST_SUITE_DETAILS_COLUMN]);
                    $this-> handleKeywords($row, $newTestSuite, $currentTestSuite);
                    $currentTestSuite->addChildElement($newTestSuite);
                    $currentTestSuite = $newTestSuite;
                } else {         
                    $currentTestSuite = $existingSuite;
                }
            }
            
            if(ElementTypes::TEST_CASE == $elementType){
                $newTestCase = new TestCaseElement();
                $newTestCase-> setName($row[CsvColumns::TEST_CASE_NAME_COLUMN]);
                $newTestCase-> setSummary($row[CsvColumns::TEST_CASE_SUMMARY_COLUMN]);
                $newTestCase-> setPreconditions($row[CsvColumns::TEST_CASE_PRECONDITIONS_COLUMN]);
                $newTestCase-> setExeType($row[CsvColumns::TEST_CASE_EXE_TYPE_COLUMN]);
                $newTestCase-> setImportance($row[CsvColumns::TEST_CASE_IMPORTANCE_COLUMN]);
                $this-> handleStep($row, $newTestCase);
                $this-> handleRequirements($row, $newTestCase);
                $this-> handleCustomFields($columnHeaders, $row, $newTestCase);
                $this-> handleKeywords($row, $newTestCase, $currentTestSuite);
                $currentTestSuite-> addChildElement($newTestCase);
                $currentTestCase = $newTestCase;
            }
            
            if(ElementTypes::STEPS == $elementType) {
                $this->handleStep($row, $currentTestCase);
            }
        }
        
        return $parentTestSuite;
    }
    
    private function handleKeywords($row, $element, $parent) {        
        //keywords are copied from parent first by default
        $keywordsArray = $parent->keywordsArray;
        $keywords = $row[CsvColumns::KEYWORDS];        
        $newKeywords = array_map('trim', explode(self::KEYWORD_DELIMETER, $keywords));
        $newKeywords = array_filter($newKeywords, 'strlen');
        $keywordsArray = array_merge($keywordsArray, $newKeywords);
        
        foreach($keywordsArray as $keyword) {
            $element->addKeyword($keyword);
        }
    }
    
    private function handleStep($row, $testCase) {
        $stepName = $row[CsvColumns::STEP_COLUMN];
        $stepExpResult = $row[CsvColumns::STEP_EXP_RESULT_COLUMN];
        $stepExeType = $row[CsvColumns::STEP_EXP_TYPE_COLUMN];
        $testCase->addStep($stepName, $stepExpResult, $stepExeType);
    }
    
    private function handleRequirements($row, $testCase) {
        $title = $row[CsvColumns::TEST_CASE_REQ_TITLE];
        $docId = $row[CsvColumns::TEST_CASE_REQ_DOC_ID];
        if(!empty($title) && !empty($docId)) {
            $testCase->addRequirement($title, $docId);
        }
    }
    
    private function handleCustomFields($columnHeaders, $row, $testCase) {
        $currentColumn = CsvColumns::CUSTOM_FIELDS_START_COLUMN;
        while(!empty($columnHeaders[$currentColumn])) {
            if(!empty($row[$currentColumn])) {
                $testCase-> addCustomField($columnHeaders[$currentColumn], $row[$currentColumn]);
            }
            $currentColumn++;
        }
    }
}