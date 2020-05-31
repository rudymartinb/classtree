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
}

