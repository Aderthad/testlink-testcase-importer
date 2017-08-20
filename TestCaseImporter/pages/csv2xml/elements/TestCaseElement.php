<?php
include_once(__DIR__."/TestStepElement.php");

class TestCaseElement extends Element {
   public $summary;
   public $preconditions;
   public $exeType;
   public $importance;
   public $steps;
   public $requirements;
   public $customFields;
   
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
    
    function addStep($stepName, $stepExpResult, $stepExeType){
        if(empty($this->steps)) {
            $this->steps = new Element(ElementTypes::STEPS);
            $this->addChildElement($this->steps);
        }
        
        $step = new TestStepElement();
        $step->setStepNumber(count($this->steps->childrenElements) + 1);
        $step->setActions($stepName);
        $step->setExpectedResults($stepExpResult);
        $step->setExecutionType($stepExeType);
        $this->steps->addChildElement($step);
    }
    
    function addRequirement($title, $docId) {
        if(empty($this->requirements)) {
            $this-> requirements = new Element(ElementTypes::REQUIREMENTS);
            $this-> addChildElement($this->requirements);
        }
        $requirement = new Element(ElementTypes::REQUIREMENT);
        $reqTitle = new Element(ElementTypes::REQ_TITLE);
        $reqTitle->content = $title;
        $reqDocId = new Element(ElementTypes::REQ_DOC_ID);
        $reqDocId->content = $docId;
        $requirement-> addChildElement($reqTitle);
        $requirement-> addChildElement($reqDocId);
        $this-> requirements-> addChildElement($requirement);
    }  
    
    function addCustomField($name, $value) {
        if(empty($this->customFields)) {
            $this-> customFields = new Element(ElementTypes::CUSTOM_FIELDS);
            $this-> addChildElement($this->customFields);
        }
        $customField = new Element(ElementTypes::CUSTOM_FIELD);
        $customFieldName = new Element(ElementTypes::CUSTOM_FIELD_NAME);
        $customFieldName->content = $name;
        $customFieldValue = new Element(ElementTypes::CUSTOM_FIELD_VALUE);
        $customFieldValue->content = $value;
        $customField-> addChildElement($customFieldName);
        $customField-> addChildElement($customFieldValue);
        $this-> customFields-> addChildElement($customField);
    }
}
