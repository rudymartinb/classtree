<?php

use function src\force_interface;

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
    
