<?php

use diagram\diagram;

class diagram_Test extends PHPUnit\Framework\TestCase {
	function test_empty(){
		$diagram = new diagram();
		$this->assertEquals(0, $diagram->get_num_elements() );
	}
	
	function test_add_source(){
		$source = "";
		$diagram = new diagram();
		$diagram->add_source($source);
		$this->assertEquals(0, $diagram->get_num_elements() );
	}
	
	function test_class_getname(){
		$source = "class myclass {}";
		$diagram = new diagram();
		$diagram->add_source($source);
		$this->assertEquals(1, $diagram->get_num_elements() );
		
		$element = $diagram->get_element_by_name( "myclass" );
		$this->assertEquals("myclass", $element->get_name() );
	}
	
}

