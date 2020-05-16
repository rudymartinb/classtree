<?php

use function src\force_class;

/* TODO: ?
 * see if we can use a "public" array and remove elements dynamically as they added to the tree 
 * in order to avoid very large arrays
 * 
 */
function get_tree( Array $classes, string $parent = "" ){
    $tree = [];
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
        $newtree = [ "name" => $class->get_name(), "childrens" => $childrens, "width" => 1 ];
        
        /* calculate tree width
         */
        $max = $newtree[ "width" ];
        $actual = 0;
        foreach( $newtree["childrens"] as $child ){
            $actual += $child["width"];
        }
        if( $actual > $max ){
            $max = $actual;
        }

        /* update tree width
         */
        $newtree["width"] = $max;
        
        
        $tree[] = $newtree ;
    }
    return  $tree;
}

function get_max_width( Array & $trees ) : int {
    $max = 0;
    foreach( $trees as $tree ){
        $max += $tree["width"] ;
    }
    return $max;
}