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
    
    
    
}

