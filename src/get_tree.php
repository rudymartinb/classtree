<?php

use function src\force_class;

/* from the array of classes
 * generate a new array of trees containing the class hierachy for each parent class
 * also it will calculate the "width" of each tree 
 */
function get_tree( Array $classes, string $parent = "" ){
    $tree = [];
    foreach( $classes as $class ){
        if( $parent !== "" ){
            $class = force_class($class);
            $found = false;
            foreach( $class->get_extends() as $thisparent ){
                if( $thisparent == $parent ){
                    $found = true;
                    break;
                }
                continue;
            }
            if( ! $found ){
                continue;
            }
        } else {
            // this is necessary to avoid adding subclases as if they were parent clases
            if( count( $class->get_extends() ) != 0){
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