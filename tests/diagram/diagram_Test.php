<?php

use diagram\diagram;

class diagram_Test extends PHPUnit\Framework\TestCase {
	function test_new(){
		$diagram = new diagram();
		$this->assertEquals(0, $diagram->get_num_elements() );
		
	}
}

