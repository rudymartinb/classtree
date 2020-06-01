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
		$element->set_namespace("nsname");
		
		$this->assertEquals( "class", $element->get_type() );
		$this->assertEquals( "class1", $element->get_name() );
		$this->assertEquals( "nsname", $element->get_namespace() );
		
		$this->assertFalse( $element->is_placed() );
		
	}

	function test_set_position(){
		$element = new element();
		
		$element->set_type("class");
		$element->set_name("class1");
		$element->set_position(0,0);
		
		$this->assertTrue( $element->is_placed() );
		
	}
}
