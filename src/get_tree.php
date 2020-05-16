<?php

use function src\force_class;

/* TODO: ?
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
        
        /* generate new element to be added to the tree
         */
        $childrens = get_tree( $classes, $class->get_name() );
        $tree = [ "name" => $class->get_name(), "childrens" => $childrens, "width" => 1 ];
        
        /* calculate tree width
         */
        $max = $tree[ "width" ];
        $actual = 0;
        foreach( $tree["childrens"] as $child ){
            $actual += $child["width"];
        }
        if( $actual > $max ){
            $max = $actual;
        }

        /* update tree width
         */
        $tree["width"] = $max;
        
        
        $result[] = $tree ;
    }
    return  $result;
}

function get_max_width( Array & $trees ) : int {
    $max = 0;
    foreach( $trees as $tree ){
        $max += $tree["width"] ;
    }
    return $max;
}