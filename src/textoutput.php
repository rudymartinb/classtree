<?php
function textoutput( Array $trees ){
    if( count( $trees ) == 0 ){
        return "";
    }
    $text = "";
    foreach( $trees as $tree ){
        if( $text != "" ){
            $text .= "\n";
        }
        $text .= $tree["name"];
    }
    $text .= "\n";
    return $text;
}