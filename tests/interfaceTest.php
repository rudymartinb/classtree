<?php

use src\interface_;


class interfaceTest extends PHPUnit\Framework\TestCase {
    function test_new(){
        $interface = new interface_( "something_interface" );
        
        $this->assertEquals("something_interface", $interface->get_name() );
        
    }
}

