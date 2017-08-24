<?php
class EntityElement extends Element {
    public $keywords;
    public $keywordsArray = array();
    
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
