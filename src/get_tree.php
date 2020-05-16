<?php

use function src\force_class;

/* todo:
 * see if we can use a "public" array and remove elements dynamically as they added to the tree 
 * in order to avoid very large arrays
 * 
 */
function get_tree( Array $classes, string $parent = "" ){
    $result = [];
    foreach( $classes as $class ){
        if( $parent != "" ){
            $class = force_class($class);
            if( $class->get_extends() !== $parent ){
                continue;
            }
        } else {
            // this is necessary to avoid adding subclases as if they were parent clases
            if( $class->get_extends() != ""){
                continue;
            }
        }
        $result[] = [ "name" => $class->get_name(), "childrens" => get_tree( $classes, $class->get_name() ) ] ;
    }
    return  $result;
}

function get_max_width( Array $trees ) : int {
    $max = count( $trees );
    foreach( $trees as $tree ){
        $tmp = get_max_width( $tree["childrens"] );
        if( $tmp > $max ){
            $max = $tmp;
        }
    }
    return $max;
}