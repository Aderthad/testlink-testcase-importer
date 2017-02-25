<?php

class ElementFormatter {
        
    private static $attributeFormatString = ' %s="%s"';        
    private static $cdata_start = '<![CDATA[';
    private static $cdata_end = ']]>';
    
    static function formatElement($e)
    {           
        $builder = '<'.$e->elementType;
                
        $builder.= self::formatAttributes($e->attributes);
        
        $builder.= '>';
        
        $builder.= self::formatContent($e->content);

        $builder.= self::formatChilren($e->childrenElements);
        
        $builder.= '</'.$e->elementType.'>';
        
        return $builder;
    }
    
    private static function formatAttributes($as)
    {
        $builder = "";     
        foreach ($as as $loop)
        {           
           $builder.= sprintf(self::$attributeFormatString, $loop->name, htmlentities($loop->value));
        }
        return $builder;
    }
    
    private static function formatContent($c)
    {        
        if (strlen($c) == 0) {
            return "";
        }
        return self::$cdata_start.$c.self::$cdata_end;
    }
    
    private static function formatChilren($cs){
        $builder = "";
        foreach ($cs as $child)
        {            
            $builder.= $child->build();
        }
        return $builder;
    }
}