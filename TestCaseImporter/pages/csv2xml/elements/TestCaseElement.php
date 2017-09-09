<?php
include_once(__DIR__."/TestStepElement.php");
include_once(__DIR__."/EntityElement.php");

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class represents a TestLink test case XML element.
 */
class TestCaseElement extends EntityElement {
   public $summary;
   public $preconditions;
   public $exeType;
   public $importance;
   public $steps;
   public $requirements;
   public $customFields;
   
   /**
    * Default construtor.
    */
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

    /**
     * Sets this element's summary.
     * @param string $summary summary to be set.
     */
    function setSummary($summary) {
         $this-> summary -> content = $summary;
    }
    
    /**
     * Sets this element's preconditions.
     * @param string $preconditions preconditions to be set.
     */
    function setPreconditions($preconditions) {
         $this-> preconditions -> content = $preconditions;
    }
    
    /**
     * Sets this element's execution type.
     * @param string $exeType execution type to be set.
     */
    function setExeType($exeType) {
         $this-> exeType -> content = $exeType;
    }
    
    /**
     * Sets this element's importace.
     * @param string $importance importace to be set.
     */
    function setImportance($importance) {
         $this-> importance -> content = $importance;
    }
    
    /**
     * Adds a new step to this element's steps.
     * @param string $stepName name of the step to be added
     * @param string $stepExpResult expected result of the step to be added
     * @param string $stepExeType execution type of the step to be added
     */
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
    
    /**
     * Adds a new requirement to this element's requirements.
     * @param string $title title of the requirement to be added
     * @param string $docId document ID of the requirement to be added
     */
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
    
    /**
     * Adds a new custom field to this element's custom fields.
     * @param string $name name of the custom field to be added
     * @param string $value value of the custom field to be added
     */
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
