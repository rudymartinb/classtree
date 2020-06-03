<?php

use diagram\VerticalLayout;

class VerticalLayout_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$layout = new VerticalLayout();
		$this->assertEquals( 0, $layout->get_num_components() );
		
	}
}

