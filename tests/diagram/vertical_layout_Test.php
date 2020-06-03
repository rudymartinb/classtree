<?php

use diagram\vertical_layout;
use diagram\draw_text;

class vertical_layout_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$layout = new vertical_layout();
		$this->assertEquals( 0, $layout->get_num_components() );
	}

	/*
	 * this tests depends on draw_text style of text
	 * if font and/or size is changed, it will fail.
	 * 
	 * TODO: create a mock to avoid this
	 */
	function test_1(){
		$layout = new vertical_layout();
		$mytext = new DrawTextMock("something goes here",  100, 20 );
		$layout->add( $mytext );
		
		$this->assertEquals( 1, $layout->get_num_components() );
		$this->assertEquals( 30, $layout->get_max_height() );
		$this->assertEquals( 110, $layout->get_max_width() );
		
		
	}
	
}

