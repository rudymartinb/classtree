<?php
function textoutput( Array $trees, int $level = 0, $subfix = "" ){
    if( count( $trees ) == 0 ){
        return "";
    }
    $text = "";
    for( $index = 0; $index < count( $trees ) ; $index++ ){
        $tree = $trees[ $index ];
        $text .= $subfix.$tree["name"];
        $imp_line = "(Implements: ";
        foreach( $tree[ "implements" ] as $implements ){
            if( $imp_line !== "(Implements: "){
                $imp_line .= ",";
            }
            $imp_line .= $implements;
        }
        if( $imp_line !== "(Implements: "){
            $imp_line = " ".$imp_line.")";
        } else {
            $imp_line = "";
        }
        $text .= $imp_line."\n";
        if( count($tree["childrens"]) >0 ){
            if( $index >= count($trees)-1){
                $subfix2 = str_replace("+", " ", $subfix)." +";
            } else{
                $subfix2 = str_replace("+", "|", $subfix)." +";
            }
            
//             $replace = $subfix;
            
//             $replace = " | +";
            $text .= textoutput( $tree["childrens"], $level+1, $subfix2 );
        }
    }
    
    return $text;
}