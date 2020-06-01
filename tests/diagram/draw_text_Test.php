<?php

use diagram\draw_text;

class draw_text_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		/*
		 * 0 	lower left corner, X position
1 	lower left corner, Y position
2 	lower right corner, X position
3 	lower right corner, Y position
4 	upper right corner, X position
5 	upper right corner, Y position
6 	upper left corner, X position
7 	upper left corner, Y posi
		 * 
		 */
		/*
		 * height: 1-5
		 * width : 0-4
		 */
		$text = "Sarasa estuvo aqui";
		var_dump( $arr );
		
		$textobj = new draw_text( $text, 0,0 );
		$this->assertEquals( 144, $textobj->get_width()  );
		$this->assertEquals( 13, $textobj->get_height()  );
	}
}

