<?php
namespace src; 

use function src\force_class;
use src\class_;

/* from the array of classes
 * generate a new array of trees containing the class hierachy for each parent class
 * also it will calculate the "width" of each tree
 * 
 *  
 */
class Tree {
    private $classes;
    function __construct( Array $classes ){
        $this->classes = $classes;
    }
    
    private $tree = [];
    function count_parents() : int {
        return count( $this->tree );
    }
    
    /* just the total width of each parent tree
     */
    function total_width() : int {
        $max = 0;
        foreach( $this->tree as $tree ){
            $max += $tree["width"];
        }
        return $max;
    }
    
    /* the maximum height of all parent tree
     */
    function total_height() : int {
        $max = 0;
        foreach( $this->tree as $tree ){
            $actual = $tree["height"];
            if( $actual > $max ){
                $max = $actual;
            }
        }
        return $max;
    }
    
    function process() {
        $this->tree = $this->get_tree( $this->classes );    
    }
    
    private function get_tree( Array $classes, string $parent = "" ){
        $tree = [];
        foreach( $classes as $class ){
            $class = force_class( $class );
            
            if( $parent !== "" ){
                // not the child we are looking for?
                if( ! $class->is_child_of( $parent ) ){
                    continue;
                }
            } else {
                // this is necessary to avoid adding subclases to the top 
                // as if they were parent clases
                if( $class->is_child() ){
                    continue;
                }
            }
            
            /* generate new element to be added to the tree
             * by doing a recursive call, 
             * we ensure the bottom order is analized first
             */
            $children = $this->get_tree( $classes, $class->get_name() );
            
            $name = $class->get_name();
            $extends = $class->get_extends();
            $implements = $class->get_implements();
            $abstract = $class->get_abstract();
            $final = $class->get_final();
            $namespace = $class->get_namespace();
            
            $newtree = [ 
                "name" => $name, 
                "extends" => $extends, 
                "childrens" => $children, 
                "width" => $this->max_width( $children ),
                "height" => $this->max_height( $children ), 
                "implements" => $implements, 
                "abstract" => $abstract, 
                "final" => $final, 
                "namespace" => $namespace 
            ];
            
            $tree[] = $newtree ;
        }
        return  $tree;
    }
    
    private function max_width( Array $children ) : int {
        $maxwidth = 1;
        $actual = 0;
        foreach( $children as $child ){
            $actual += $child["width"];
        }
        if( $actual > $maxwidth ){
            $maxwidth = $actual;
        }
        return $maxwidth;
    }
    
    private function max_height( Array $children ) : int {
        $actual = 0;
        $maxheight = 0;
        foreach( $children  as $child ){
            $actual = $child["height"];
            if( $actual > $maxheight ){
                $maxheight = $actual;
            }
        }
        $maxheight = $actual + 1;
        return $maxheight;
    }
    
    
        
    
    
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
        $extends = $class->get_extends();
        $implements = $class->get_implements();
        $abstract = $class->get_abstract();
        $final = $class->get_final();
        $namespace = $class->get_namespace();
        $newtree = [ "name" => $name, "extends" => $extends , "childrens" => $childrens, "width" => 1, "implements" => $implements, "abstract" => $abstract, "final" => $final, "namespace" => $namespace ];
        
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