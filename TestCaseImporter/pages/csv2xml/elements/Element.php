<?php
require_once(__DIR__.'/Attribute.php');
require_once(__DIR__.'/ElementFormatter.php');

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class represents an XML element.
 */
class Element
{
    private $elementAttributeName = "name";
    
    public $elementType;
    public $content = "";
    public $attributes = array();    
    public $childrenElements = array();
    public $elementName = "";
    
    /**
     * Default constructor which sets this element's element type.
     * @param string $type
     */
    public function __construct($type) {
        $this->elementType = $type;
    }
    
    /**
     * Sets this element's name.
     * @param string $name this element's name to be set
     */
    public function setName($name) {
        $this->elementName = $name;
        $this->addAttribute($this->elementAttributeName, $name);
    }
    
    /**
     * Adds an attribute to this elemet's attributes.
     * @param string $name name of the attribue to be added
     * @param string $value value of the attribue to be added
     */
    public function addAttribute($name, $value)
    {   
        $newAtt = new Attribute();
        $newAtt->name = $name;
        $newAtt->value = $value;
        $this->attributes[] = $newAtt;
    }
    
    /**
     * Adds an element to this element's child elements.
     * @param Element $ce child element
     */
    public function addChildElement($ce)
    {
        $this->childrenElements[] = $ce;
    }
    
    /**
     * Gets this element's child by its element type and name. Returns null
     * if such element doesn't exist.
     * @param string $name
     * @param string $category
     * @return Element or null child element
     */
    public function getChildElement($name, $category) {
        foreach ($this->childrenElements as $children) {
            if($category == $children->elementType && $name == $children->elementName) {
                return $children;
            }
        }
        return null;
    }
    
    /**
     * Returns this element as a formatted XML string.
     * @return string this element as a XML string
     */
    public function build()
    {   
        return ElementFormatter::formatElement($this);
    }
}