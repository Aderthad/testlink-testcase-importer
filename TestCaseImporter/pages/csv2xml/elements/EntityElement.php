<?php

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class represents an XML element with support for keywords.
 */
class EntityElement extends Element {
    public $keywords;
    public $keywordsArray = array();
    
    /**
     * Adds a keyword to this element's keywords (if it doesn't already exits).
     * @param string $keyword key word to be added
     */
    public function addKeyword($keyword){
        if(in_array($keyword, $this->keywordsArray)) {
            return;
        }
        if(empty($this->keywords)) {
            $this->keywords = new Element(ElementTypes::KEYWORDS);
            $this->addChildElement($this->keywords);
        }
        
        $keywordElement = new Element(ElementTypes::KEYWORD);
        $keywordElement->setName($keyword);
        $this->keywords->addChildElement($keywordElement);        
        $this->keywordsArray[] = $keyword;
    }    
}
