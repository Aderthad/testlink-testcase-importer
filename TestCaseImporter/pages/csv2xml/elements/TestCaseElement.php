<?php
class TestCaseElement extends Element {
   public $summary;
   public $preconditions;
   public $exeType;
   public $importance;
   public $step;
   public $exptectedResult;
   
   private $eol = "\r\n";
           
    function __construct() {
        parent::__construct(ElementTypes::TEST_CASE);
        
        $this-> summary = new Element(ElementTypes::SUMMARY);
        $this-> addChildElement($this-> summary);
        
        $this-> preconditions = new Element(ElementTypes::PRECONDITIONS);
        $this-> addChildElement($this-> preconditions);
        
        $this-> exeType = new Element(ElementTypes::EXE_TYPE);
        $this-> addChildElement($this-> exeType);

        $this-> importance = new Element(ElementTypes::IMPORTANCE);
        $this-> addChildElement($this-> importance);
        
        $this-> step = new Element(ElementTypes::STEPS);
        $this-> addChildElement($this-> step);
        
        $this-> exptectedResult = new Element(ElementTypes::EXP_RESULT);
        $this-> addChildElement($this-> exptectedResult);
    }
            
    function setSummary($summary) {
         $this-> summary -> content = $summary;
    }
    
    function setPreconditions($preconditions) {
         $this-> preconditions -> content = $preconditions;
    }
    
    function setExeType($exeType) {
         $this-> exeType -> content = $exeType;
    }
    
    function setImportance($importance) {
         $this-> importance -> content = $importance;
    }
    
    function addStep($step){
        $this-> step -> content .= $this-> eol.$step;
    }
    
    function addExpResult($expResult){
        $this-> exptectedResult -> content .= $this-> eol.$expResult;
    }
}
