<?php

use diagram\vertical_layout;
use diagram\draw_text;
use diagram\draw_line;

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
// 		$layout->add( $mytext );
		$layout->add_text( "something goes here" );
		$layout->do_layout();
		$this->assertEquals( 1, $layout->get_num_components() );
		$this->assertEquals( 33, $layout->get_max_height() );
		$this->assertEquals( 110, $layout->get_max_width() );
		
		$this->assertEquals( 25, $mytext->get_x() );
		$this->assertEquals( 48, $mytext->get_y() );
	}

	
// 	function test_2(){
// 		$layout = new vertical_layout();
// 		$layout->set_margin(5);
// 		$layout->set_xy( 20,20 );
// 		$mytext = new DrawTextMock("something goes here",  100, 20 );
// 		$layout->add( $mytext );
// 		$mytext = new DrawTextMock("shorter",  50, 20 );
// 		$layout->add( $mytext );
// 		$layout->do_layout();
// 		$this->assertEquals( 2, $layout->get_num_components() );
// 		$this->assertEquals( 56, $layout->get_max_height() );
// 		$this->assertEquals( 110, $layout->get_max_width() );
		
// 		$this->assertEquals( 25, $mytext->get_x() );
// 		$this->assertEquals( 71, $mytext->get_y() );
// 	}

// 	function test_draw(){
// 		$layout = new vertical_layout();
// 		$layout->set_margin(5);
// 		$layout->set_xy( 20,20 );
// 		$mytext = new DrawTextMock("something goes here",  100, 20 );
		
// 		// this test pass only if this function is executed
// 		// as replacement of the propper graphic function
// 		$mytext->set_draw_function(
// 				function() { $this->assertTrue( true ); }
// 		);
// 		$layout->add( $mytext );
// 		$layout->do_layout();
		
// 		$layout->draw( 1 );
// 	}

	
// 	function test_draw_line(){
// 		$layout = new vertical_layout();
// 		$layout->set_margin(5);
// 		$layout->set_xy( 20,20 );
// 		$myline = new draw_line();
		
// 		// this test pass only if this function is executed
// 		// as replacement of the propper graphic function
// 		$myline->set_draw_function(
// 				function() { $this->assertTrue( true ); }
// 		);
// 		$layout->add( $myline );
// 		$layout->do_layout();
		
// 		$layout->draw( 1 );
// 	}


	
	
}

