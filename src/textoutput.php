<?php
function textoutput( Array $trees, int $level = 0 ){
    if( count( $trees ) == 0 ){
        return "";
    }
    $text = "";
    foreach( $trees as $tree ){
        $text .= $tree["name"];
        $text .= "\n";
        if( count($tree["childrens"]) >0 ){
            $subfix = str_repeat("+ ", $level+1);
            $text .= $subfix . textoutput( $tree["childrens"], $level+1 );
        }
    }
    
    return $text;
}