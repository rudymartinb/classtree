<?php

use function src\force_class;
use src\class_;

/* from the array of classes
 * generate a new array of trees containing the class hierachy for each parent class
 * also it will calculate the "width" of each tree
 * 
 *  
 */

function is_child_of( class_ $class, string $parent ) : bool {
    foreach( $class->get_extends() as $thisparent ){
        if( $thisparent == $parent ){
            return true;
        }
        continue;
    }
    foreach( $class->get_interface_extends() as $thisparent ){
        if( $thisparent == $parent ){
            return true;
        }
        continue;
    }
    
    return false;
}
function is_child( class_ $class ) : bool {
    return count( $class->get_extends() ) != 0 or count( $class->get_interface_extends() ) != 0;
}

function get_tree( Array $classes, string $parent = "" ){
    $tree = [];
    foreach( $classes as $class ){
        if( $parent !== "" ){
            $class = force_class($class);
            
            if( ! is_child_of($class, $parent) ){
                continue;
            }
        } else {
            // this is necessary to avoid adding subclases as if they were parent clases
            if( is_child($class) ){
                continue;
            }
        }
        
        /* generate new element to be added to the tree
         */
        $childrens = get_tree( $classes, $class->get_name() );
        $name = $class->get_name();
        $implements = $class->get_implements();
        $abstract = $class->get_abstract();
        $final = $class->get_final();
        $namespace = $class->get_namespace();
        $newtree = [ "name" => $name, "childrens" => $childrens, "width" => 1, "implements" => $implements, "abstract" => $abstract, "final" => $final, "namespace" => $namespace ];
        
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
        
//         echo "adding ".$class->get_name()."\n";
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