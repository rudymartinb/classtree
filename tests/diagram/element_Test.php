<?php

use diagram\element;

class element_Test extends PHPUnit\Framework\TestCase {
	
	function test_basic(){
		$element = new element();
		$this->assertFalse( $element->is_placed() );
	}

	function test_just_name(){
		$element = new element();
		
		$element->set_type("class");
		$element->set_name("class1");
		$element->set_extends("super");
		$element->set_usetraits("trait1");
		$element->set_position(10, 10);
		$functions = [];
		for( $i=1;$i<10;$i++){
			$functions[] = "function".$i."()";
			
		}
		$element->set_functions($functions);
		
		$element->draw( 0);
		
		$this->assertEquals( 5+48+5, $element->get_width() );
		$this->assertEquals( 5+13+5, $element->get_height() );
		
	}
	
	

}
