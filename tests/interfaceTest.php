<?php

use src\interface_;


class interfaceTest extends PHPUnit\Framework\TestCase {
    function test_get_name(){
        $interface = new interface_( "something_interface" );
        $this->assertEquals("something_interface", $interface->get_name() );
    }
    
    function test_extends(){
        $interface = new interface_( "something_interface" );
        $interface->add_extends( "other_interface" );
        $interface->add_extends( "another_interface" );
        
        $list = $interface->get_extends();
        
        $this->assertEquals( 2, count( $list ) );
    }
    
    function test_is_extends_resolved_OK(){
        $interface = new interface_( "something_interface" );
//         $interface->add_extends( "other_interface" );
//         $interface->add_extends( "another_interface" );
        
//         $list = $interface->get_extends();
        
        $this->assertTrue( $interface->is_extends_resolved() );
    }

    function test_is_extends_resolved_FALSE(){
        $interface = new interface_( "something_interface" );
        $interface->add_extends( "other_interface" );
        //         $interface->add_extends( "another_interface" );
        
        //         $list = $interface->get_extends();
        
        $this->assertFalse( $interface->is_extends_resolved() );
    }
    

    function test_resolve_extends(){
        $interface = new interface_( "something_interface" );
        $interface->add_extends( "other_interface" );
        $interface->add_extends( "another_interface" );
        
        $list =[];
        $list[] = $interface;
        
        $list[] =  new interface_( "other_interface" );
        $list[] =  new interface_( "another_interface" );
        
        $interface->resolve_extends($list);
        var_dump($interface);
        $this->assertTrue( $interface->is_extends_resolved() );
        
    }
    
    
    
}

