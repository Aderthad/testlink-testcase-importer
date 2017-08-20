<?php
class TestStepElement extends Element {
    const DEFAULT_EXE_TYPE = '1';
    
    private $step_number;
    private $actions;
    private $expectedresults;
    private $execution_type;
    
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
    
    public function setStepNumber($step_number) {
        $this->step_number->content = $step_number;
    }

    public function setActions($actions) {
        $this->actions->content = $actions;
    }

    public function setExpectedResults($expectedresults) {
        $this->expectedresults->content = $expectedresults;
    }

    public function setExecutionType($execution_type) {
        if(!empty($execution_type)) {
            $this->execution_type->content = $execution_type;
        }
    }
}
