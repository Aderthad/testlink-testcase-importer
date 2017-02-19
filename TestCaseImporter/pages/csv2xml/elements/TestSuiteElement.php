<?php
class TestSuiteElement extends Element {
    
    public $detail;
    
    function __construct() {
        parent::__construct(ElementTypes::TEST_SUITE);
      
        $this-> detail = new Element(ElementTypes::DETAILS);
        $this-> addChildElement($this-> detail);
    }
            
    function setDetail($detail) {
         $this-> detail -> content = $detail;
    }
}
