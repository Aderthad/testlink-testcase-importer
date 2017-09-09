<?php

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class represents a TestLink step XML element.
 */
class TestStepElement extends Element {
    const DEFAULT_EXE_TYPE = '1';
    
    public $step_number;
    public $actions;
    public $expectedresults;
    public $execution_type;
    
    /**
     * Default constructor.
     */
    function __construct() {
        parent::__construct(ElementTypes::STEP);
        
        $this-> step_number = new Element(ElementTypes::STEP_NUMBER);
        $this-> addChildElement($this-> step_number);
        
        $this-> actions = new Element(ElementTypes::STEP_ACTIONS);
        $this-> addChildElement($this-> actions);
        
        $this-> expectedresults = new Element(ElementTypes::STEP_EXP_RESULTS);
        $this-> addChildElement($this-> expectedresults);

        $this-> execution_type = new Element(ElementTypes::STEP_EXE_TYPE);
        $this-> execution_type -> content = self::DEFAULT_EXE_TYPE;
        $this-> addChildElement($this-> execution_type);
    }
    
    /**
     * Sets this step's number.
     * @param integer $step_number this step's number
     */
    public function setStepNumber($step_number) {
        $this->step_number->content = $step_number;
    }

    /**
     * Sets this step's actions.
     * @param string $actions this step's actions
     */
    public function setActions($actions) {
        $this->actions->content = $actions;
    }

    /**
     * Sets this step's expected results.
     * @param string $expectedresults this step's expected results
     */
    public function setExpectedResults($expectedresults) {
        $this->expectedresults->content = $expectedresults;
    }

    /**
     * Sets this step's execution type.
     * @param string $execution_type his step's execution type
     */
    public function setExecutionType($execution_type) {
        if(!empty($execution_type)) {
            $this->execution_type->content = $execution_type;
        }
    }
}
