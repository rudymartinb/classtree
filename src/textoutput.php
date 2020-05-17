<?php
function textoutput( Array $trees, int $level = 0 ){
    if( count( $trees ) == 0 ){
        return "";
    }
    $text = "";
    foreach( $trees as $tree ){
        $text .= $tree["name"];
        $text .= "\n";
        $subfix = "";
        if( count($tree["childrens"]) >0 ){
            if( $level = 1 ){
                $subfix = "+ ";
            }
            $text .= $subfix . textoutput( $tree["childrens"], $level+1 );
        }
    }
    
    return $text;
}