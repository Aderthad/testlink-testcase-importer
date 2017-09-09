<?php
include_once(__DIR__."/CsvRows.php");
include_once(__DIR__."/RowIdentifier.php");
include_once(__DIR__."/../elements/Element.php");
include_once(__DIR__."/../elements/ElementTypes.php");
include_once(__DIR__."/../elements/TestCaseElement.php");
include_once(__DIR__."/../elements/TestSuiteElement.php");

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class is responsible for parsing csv array and creating an object structure
 * of XML elements.
 */
class Parser {
    
    const KEYWORD_DELIMETER = ',';
    
    /**
     * This function creates a parent TestSuiteElement and adds parsed 
     * elements from the input csv array as its children.
     * @param array $csv csv array
     * @return TestSuiteElement parent element containing parsed elements from imput csv array
     */
    function parse($csv) {
        // remove column headers
        $columnHeaders = array_shift($csv);        
        // create parent TestSuiteElement that will be returned
        $parentTestSuite = new TestSuiteElement();
        // current test suite, following test suites and cases will be its children
        $currentTestSuite = $parentTestSuite;
        // prepare a test case variable. Test case steps will be added there.
        $currentTestCase = null;
        
        foreach ($csv as $row) {
            // get ElementType of the current row (based on first non-empty column)
            $elementType = RowIdentifier::identifyElementType($row);
            
            // handle TEST_SUITE element type
            if(ElementTypes::TEST_SUITE == $elementType){
                // if there is an current test case set, it means the previous row was
                // the last test case for current test suite.
                // set current test case to null and reset current test suite
                // to the parent test suite.
                if(!empty($currentTestCase)) {
                    $currentTestSuite = $parentTestSuite;
                    $currentTestCase = null;
                }                
                
                // try to get existing test suite from current test suites children
                $existingSuite = $currentTestSuite-> getChildElement($row[CsvColumns::TEST_SUITE_NAME_COLUMN], ElementTypes::TEST_SUITE);
                // if it doesn't exist, create it and set it as current test suite
                if(empty($existingSuite)) {
                    $newTestSuite = new TestSuiteElement();
                    $newTestSuite-> setName($row[CsvColumns::TEST_SUITE_NAME_COLUMN]);                    
                    $newTestSuite-> setDetail($row[CsvColumns::TEST_SUITE_DETAILS_COLUMN]);
                    $this-> handleKeywords($row, $newTestSuite, $currentTestSuite);
                    $currentTestSuite-> addChildElement($newTestSuite);
                    $currentTestSuite = $newTestSuite;
                } else {
                    // if it does, just set it as current test suite
                    $currentTestSuite = $existingSuite;
                }
            }
            
            // handle TEST_CASE element type
            if(ElementTypes::TEST_CASE == $elementType){
                $newTestCase = new TestCaseElement();
                $newTestCase-> setName($row[CsvColumns::TEST_CASE_NAME_COLUMN]);
                $newTestCase-> setSummary($row[CsvColumns::TEST_CASE_SUMMARY_COLUMN]);
                $newTestCase-> setPreconditions($row[CsvColumns::TEST_CASE_PRECONDITIONS_COLUMN]);
                $newTestCase-> setExeType($row[CsvColumns::TEST_CASE_EXE_TYPE_COLUMN]);
                $newTestCase-> setImportance($row[CsvColumns::TEST_CASE_IMPORTANCE_COLUMN]);
                // handle first test case step
                $this-> handleStep($row, $newTestCase);
                $this-> handleRequirements($row, $newTestCase);
                $this-> handleCustomFields($columnHeaders, $row, $newTestCase);
                $this-> handleKeywords($row, $newTestCase, $currentTestSuite);
                $currentTestSuite-> addChildElement($newTestCase);
                // set this new test case as the current one
                $currentTestCase = $newTestCase;
            }
            
            // handle following test case steps
            if(ElementTypes::STEPS == $elementType) {
                $this-> handleStep($row, $currentTestCase);
            }
        }        
        
        return $parentTestSuite;
    }
    
    /**
     * This function merges parent element's keywords with current row's keywords
     * and sets them as keywords of the current element.
     * @param array $row current row
     * @param EntityElement $element element to add keywords to
     * @param EntityElement $parent element's parent element
     */
    private function handleKeywords($row, $element, $parent) {        
        // keywords are copied from parent first by default
        $keywordsArray = $parent->keywordsArray;
        // get keyword row
        $keywords = $row[CsvColumns::KEYWORDS];
        // parse keywords to an array and remove leading and trailing spaces for each keyword
        $newKeywords = array_map('trim', explode(self::KEYWORD_DELIMETER, $keywords));
        // remove empty keywords
        $newKeywords = array_filter($newKeywords, 'strlen');
        // merge parent's and this element's keywords together
        $keywordsArray = array_merge($keywordsArray, $newKeywords);
        // set each keyword from the array to element
        foreach($keywordsArray as $keyword) {
            $element->addKeyword($keyword);
        }
    }
    
    /**
     * This function sets steps from current row to current test case.
     * @param array $row current row
     * @param TestCaseElement $testCase current test case
     */
    private function handleStep($row, $testCase) {
        $stepName = $row[CsvColumns::STEP_COLUMN];
        $stepExpResult = $row[CsvColumns::STEP_EXP_RESULT_COLUMN];
        $stepExeType = $row[CsvColumns::STEP_EXP_TYPE_COLUMN];
        $testCase-> addStep($stepName, $stepExpResult, $stepExeType);
    }
    
    /**
     * This function sets requirements from current row to current test case.
     * @param array $row current row
     * @param TestCaseElement $testCase current test case
     */
    private function handleRequirements($row, $testCase) {
        $title = $row[CsvColumns::TEST_CASE_REQ_TITLE];
        $docId = $row[CsvColumns::TEST_CASE_REQ_DOC_ID];
        if(!empty($title) && !empty($docId)) {
            $testCase-> addRequirement($title, $docId);
        }
    }
    
    /**
     * This function sets custom fields from current row to current test case.
     * @param array $columnHeaders headers of all columns which contain custom fields names
     * @param array $row current row
     * @param TestCaseElement $testCase current test case
     */
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