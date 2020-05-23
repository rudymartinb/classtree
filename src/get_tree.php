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
        $this->tree = $this->get_tree( $this->classes );
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
    private function max_width( Array $trees ) : int {
        $actual = 0;
        foreach( $trees as $tree ){
            $actual += $tree["width"];
        }
        return $actual;
    }
    
    
    /* the maximum height of all parent tree
     */
    function total_height() : int {
        return $this->max_height($this->tree);
    }
    
    private function max_height( Array $trees ) : int {
        $maxheight = 0;
        foreach( $trees  as $tree ){
            $actual = $tree["height"];
            if( $actual > $maxheight ){
                $maxheight = $actual;
            }
        }
        return $maxheight;
    }
    
    
    private function get_tree( Array $classes, string $parent = "" ){
        $tree = [];
        
        foreach( $classes as $class ){
            $class = force_class( $class );
            
            if( $parent !== "" ){
                if( ! $class->is_child_of( $parent ) ){
                    continue;
                }
            } else {
                // this is necessary to avoid adding subclases 
                // to the top of the tree 
                // as if they were parent clases
                if( $class->is_child() ){
                    continue;
                }
            }
            
            /* generate new element to be added to the tree
             * by doing a recursive call, 
             * we ensure the bottom order is analized first
             */
            $name = $class->get_name();
            
            $children = $this->get_tree( $classes, $name );
            
            $extends = $class->get_extends();
            $implements = $class->get_implements();
            $abstract = $class->get_abstract();
            $final = $class->get_final();
            $namespace = $class->get_namespace();
            
            $tree[] = [
                "name" => $name,
                "extends" => $extends,
                "childrens" => $children,
                "width" => max( $this->max_width( $children ), 1 ),
                "height" => $this->max_height( $children )+1,
                "implements" => $implements,
                "abstract" => $abstract,
                "final" => $final,
                "namespace" => $namespace
            ];
        }
        return  $tree;
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