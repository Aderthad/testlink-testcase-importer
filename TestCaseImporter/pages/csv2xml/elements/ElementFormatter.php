<?php

class ElementFormatter {
    
    private static $UTF_8 = 'UTF-8';
    
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
           $builder.= sprintf(self::$attributeFormatString, $loop->name, htmlspecialchars($loop->value, ENT_COMPAT | ENT_HTML401, self::$UTF_8));
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