<?php

use function src\force_interface;
/*
 * interfaces poses a problem that classes have not:
 * multiple extends
 * 
 * there are two ways I could handle this:
 * 1) ignore that and build a tree for each interface on the top. 
 * worst case scenario I could have the same subinterfaces repeated among trees, 
 * but diagram should point to only one of them.
 * and the problem of this solution is how that diagram could look like
 * and it would be certanly difficult to calculate "tree width"
 *    
 * 2) build some nasty nodes relationship which could look like a tree but with several "heads"
 * 
 */
function get_interfaces_tree( Array $interfaces, string $parent = "" ) : Array {
    $tree = [];
    foreach ($interfaces as $interface){
        $interface = force_interface($interface);
        if( $parent != "" ){
            $parents = $interface->get_extends();
            $control = false;
            foreach ($parents as $parent_interface ){
                if( $parent_interface == $parent ){
                    $control = true;
                }
            }
            if( ! $control ){
                continue;
            }
        } else {
            // this is necessary to avoid adding subclases as if they were parent clases
            if( count( $interface->get_extends() ) > 0){
                continue;
            }
        }
        
        $childrens = get_interfaces_tree($interfaces, $interface->get_name());
        $newtree = [ "name" => $interface->get_name(), "childrens" => $childrens, "width" => 1 ];
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
    
