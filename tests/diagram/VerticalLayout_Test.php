<?php

use diagram\VerticalLayout;
use diagram\draw_text;

class VerticalLayout_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$layout = new VerticalLayout();
		$this->assertEquals( 0, $layout->get_num_components() );
	}

	function test_1(){
		$layout = new VerticalLayout();
		$mytext = new draw_text("something goes here");
		$layout->add( $mytext );
		
		$this->assertEquals( 1, $layout->get_num_components() );
		$this->assertEquals( 23, $layout->get_max_height() );
		$this->assertEquals( 162, $layout->get_max_width() );
		
		
	}
	
}

