<?php
require_once(__DIR__.'/Attribute.php');
require_once(__DIR__.'/ElementFormatter.php');

class Element
{
    private $elementAttributeName = "name";
    
    public $elementType;
    public $content = "";
    public $attributes = array();    
    public $childrenElements = array();
    public $elementName = "";
    
    public function __construct($type) {
        $this->elementType = $type;
    }
    
    public function setName($name) {
        $this->elementName = $name;
        $this->addAttribute($this->elementAttributeName, $name);
    }
            
    function addAttribute($n, $v)
    {   
        $newAtt = new Attribute();
        $newAtt->name = $n;
        $newAtt->value = $v;
        $this->attributes[] = $newAtt;
    }
    
    function addChildElement($ce)
    {
        $this->childrenElements[] = $ce;
    }
    
    function getChildElement($name, $category) {
        foreach ($this->childrenElements as $children) {
            if($category == $children->elementType && $name == $children->elementName) {
                return $children;
            }
        }
        return null;
    }
    
    function build()
    {   
        return ElementFormatter::formatElement($this);
    }
}