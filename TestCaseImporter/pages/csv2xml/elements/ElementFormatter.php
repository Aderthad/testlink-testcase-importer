<?php

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * The sole purpose of this class is to format given Element to its XML representation.
 */
class ElementFormatter {
    
    private static $UTF_8 = 'UTF-8';
    
    private static $attributeFormatString = ' %s="%s"';        
    private static $cdata_start = '<![CDATA[';
    private static $cdata_end = ']]>';
    
    /**
     * This function formats given Element to its XML representation.
     * @param Element $e Element to be formatted.
     * @return string given Element formatted to its XML representation
     */
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