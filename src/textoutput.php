<?php
function textoutput( Array $tree ){
    if( count( $tree ) == 0 ){
        return "";
    }
    return $tree[0]["name"];
}