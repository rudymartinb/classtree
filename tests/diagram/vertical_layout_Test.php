<?php

use diagram\vertical_layout;
use diagram\draw_text;

class vertical_layout_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$layout = new vertical_layout();
		$this->assertEquals( 0, $layout->get_num_components() );
	}

	function test_1(){
		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->set_xy( 20,20 );
		$mytext = new DrawTextMock("something goes here",  100, 20 );
		$layout->add( $mytext );
		$layout->do_layout();
		$this->assertEquals( 1, $layout->get_num_components() );
		$this->assertEquals( 30, $layout->get_max_height() );
		$this->assertEquals( 110, $layout->get_max_width() );
		
		
		// just one element
		// grid at 20,20
		// margin 5
		// equals 25 for x and y
		$this->assertEquals( 25, $mytext->get_x() );
		$this->assertEquals( 25, $mytext->get_y() );
	}

	
	function test_2(){
		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->set_xy( 20,20 );
		$mytext = new DrawTextMock("something goes here",  100, 20 );
		$layout->add( $mytext );
		$mytext = new DrawTextMock("shorter",  50, 20 );
		$layout->add( $mytext );
		$layout->do_layout();
		$this->assertEquals( 2, $layout->get_num_components() );
		$this->assertEquals( 50, $layout->get_max_height() );
		$this->assertEquals( 110, $layout->get_max_width() );
		
		
		// just one element
		// grid at 20,20
		// margin 5
		// equals 25 for x and y
		$this->assertEquals( 25, $mytext->get_x() );
		$this->assertEquals( 45, $mytext->get_y() );
	}
	
}

