<?php

use diagram\element;

class element_Test extends PHPUnit\Framework\TestCase {
	
	function test_basic(){
		$element = new element();
		$this->assertFalse( $element->is_placed() );
	}

	function test_attributes(){
		$element = new element();
		
		$element->set_type("class");
		$element->set_name("class1");
		
		$this->assertEquals( "class", $element->get_type() );
		$this->assertEquals( "class1", $element->get_name() );
		
		$this->assertFalse( $element->is_placed() );
	}
	
}
