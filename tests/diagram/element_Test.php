<?php

use diagram\element;

class element_Test extends PHPUnit\Framework\TestCase {
	
	function test_basic(){
		$element = new element();
		$this->assertFalse( $element->is_placed() );
	}

	function test_height_name(){
		$element = new element();
		
		$element->set_type("class");
		$element->set_name("class1");
		
		$this->assertEquals( 13, $element->get_height() );
		
		$element->draw();
	}
	function test_attributes(){
		$element = new element();
		
		$element->set_type("class");
		$element->set_name("class1");
		$element->set_namespace("nsname");
		$element->set_extends("superclass");
		$element->set_implements("interface1,interface2");

		
		$this->assertEquals( "class", $element->get_type() );
		$this->assertEquals( "class1", $element->get_name() );
		$this->assertEquals( "nsname", $element->get_namespace() );
		$this->assertEquals( "superclass", $element->get_extends() );
		$this->assertEquals( "interface1,interface2", $element->get_implements() );
		
		// TODO: traits and functions
		
		$this->assertFalse( $element->is_placed() );
// 		$this->assertEquals( 13+13+13+13+13, $element->get_height() );
		
	}

	function test_set_position(){
		$element = new element();
		
		$element->set_type("class");
		$element->set_name("class1");
		$element->set_position(0,0);
		
		$this->assertTrue( $element->is_placed() );
		
	}
}
