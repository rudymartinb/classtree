<?php
function textoutput( Array $trees, int $level = 0, $subfix = "" ){
    if( count( $trees ) == 0 ){
        return "";
    }
    $text = "";
    foreach( $trees as $tree ){
        $text .= $subfix.$tree["name"];
        $text .= "\n";
        if( count($tree["childrens"]) >0 ){
            $subfix2 = str_replace("+", " ", $subfix)." +";
//             $replace = $subfix;
            
//             $replace = " | +";
            $text .= textoutput( $tree["childrens"], $level+1, $subfix2 );
        }
    }
    
    return $text;
}