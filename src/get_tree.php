<?php

use function src\force_class;

function get_tree( Array $classes, string $parent = "" ){
    $result = [];
    foreach( $classes as $class ){
        if( $parent != "" ){
            $class = force_class($class);
            if( $class->get_extends() !== $parent ){
                continue;
            }
        } else {
            if( $class->get_extends() != ""){
                continue;
            }
        }
        $result[] = [ "name" => $class->get_name(), "childrens" => get_tree( $classes, $class->get_name() ) ] ;
    }
    return  $result;
}

function get_max_width( Array $tree ) : int {
    $max = 0;
    foreach( $tree as $branch ){
        $tmp = count( $branch["childrens"] )+1;
        if( $tmp > $max ){
            $max = $tmp;
        }
    }
    return $max;
}