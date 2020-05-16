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
        $childrens = get_tree( $classes, $class->get_name() );
        $tree = [ "name" => $class->get_name(), "childrens" => $childrens, "width" => count($childrens) ];
        $max = $tree[ "width" ];
        $actual = 0;
        foreach( $tree["childrens"] as $child ){
            $actual += $child["width"];
        }
        if( $actual > $max ){
            $max = $actual;
        }
        $tree["width"] = $max;
        
        
        $result[] = $tree ;
    }
    return  $result;
}

function get_max_width( Array & $trees ) : int {
    $max = count( $trees );
    foreach( $trees as $tree ){
        $tmp = $tree["width"] ;
        if( $tmp > $max ){
            $max = $tmp;
        }
    }
    return $max;
}