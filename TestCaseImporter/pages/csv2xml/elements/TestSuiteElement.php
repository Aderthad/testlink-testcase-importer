<?php
include_once(__DIR__."/EntityElement.php");

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class represents a TestLink test suite XML element.
 */
class TestSuiteElement extends EntityElement {
    
    public $detail;
    
    /**
     * Default constructor.
     */
    function __construct() {
        parent::__construct(ElementTypes::TEST_SUITE);
      
        $this-> detail = new Element(ElementTypes::DETAILS);
        $this-> addChildElement($this-> detail);
    }
    
    /**
     * Sets this element's importance.
     * @param string $detail detail to be set
     */
    function setDetail($detail) {
         $this-> detail -> content = $detail;
    }
}
