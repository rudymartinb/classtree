<?php

use src\interface_;

class interfacesTreeTest extends PHPUnit\Framework\TestCase {
    function test_0(){
        $interfaces = [];
        
        $tree = get_interfaces_tree( $interfaces );
        
        $this->assertEquals( 0, count( $tree ) );
        
    }
//     function test_1(){
//         $interfaces = [];
        
//         $interface = new interface_("parent");
//         $interfaces[] = $interface;
        
        
//     }
// 

}