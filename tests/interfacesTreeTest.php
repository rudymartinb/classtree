<?php

use src\interface_;

class interfacesTreeTest extends PHPUnit\Framework\TestCase {
    function test_0(){
        $interfaces = [];
        
        $tree = get_interfaces_tree( $interfaces );
        
        $this->assertEquals( 0, count( $tree ) );
        
    }
    
    function test_1(){
        $interfaces = [];
        
        $interface = new interface_("parent");
        $interfaces[] = $interface;
        
        $tree = get_interfaces_tree( $interfaces );
        
        $this->assertEquals( 1, count( $tree ) );
    }

    function test_2(){
        $interfaces = [];
        
        $interface = new interface_("parent");
        $interfaces[] = $interface;

        $interface = new interface_("parent2");
        $interfaces[] = $interface;
        
        $tree = get_interfaces_tree( $interfaces );
        
        $this->assertEquals( 2, count( $tree ) );
    }

    function test_parent_child(){
        $interfaces = [];
        
        $interface1 = new interface_("parent");
        $interfaces[] = $interface1;
        
        $interface2 = new interface_("child");
        $interface2->set_extends( $interface1->get_name() );
        $interfaces[] = $interface2;
        
        $tree = get_interfaces_tree( $interfaces );
        
        $this->assertEquals( 1, count( $tree ) );
    }
    

}