<?php

use diagram\diagram;

class diagram_Test extends PHPUnit\Framework\TestCase {
	function test_empty(){
		$diagram = new diagram();
		$this->assertEquals(0, $diagram->get_width() );
	}
	
	function test_add_source(){
		$source = "";
		$diagram = new diagram();
		$diagram->add_source($source);
		$this->assertEquals(0, $diagram->get_width() );
	}

	function test_class_getname(){
		$source = "class myclass {}";
		$diagram = new diagram();
		$diagram->add_source($source);
		$diagram->resolve_hiearchy();
		
// 		$this->assertEquals(1, $diagram->get_width() );
// 		$this->assertEquals(1, $diagram->get_height() );
		
// 		$this->assertEquals( 1, $diagram->get_tree_column_area() );
		$diagram->draw();

	}
	
	
}

