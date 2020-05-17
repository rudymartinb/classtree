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

    function test_nasty(){
        $interfaces = [];
        
        $interface11 = new interface_("parent11");
        $interfaces[] = $interface11;

        $interface12 = new interface_("parent12");
        $interfaces[] = $interface12;

        $interface13 = new interface_("parent13");
        $interfaces[] = $interface13;
        
        $interface21 = new interface_("child1");
        $interface21->set_extends( $interface11->get_name() );
        $interface21->set_extends( $interface12->get_name() );
        $interfaces[] = $interface21;

        $interface22 = new interface_("child2");
        $interface22->set_extends( $interface12->get_name() );
        $interface22->set_extends( $interface13->get_name() );
        $interfaces[] = $interface22;

        $interface23 = new interface_("child2");
        $interface23->set_extends( $interface11->get_name() );
        $interface23->set_extends( $interface13->get_name() );
        $interfaces[] = $interface23;
        
        
        $tree = get_interfaces_tree( $interfaces );
        
        $this->assertEquals( 3, count( $tree ) );
        
        $this->assertEquals( 6, get_max_width( $tree ) );
    }
    

}