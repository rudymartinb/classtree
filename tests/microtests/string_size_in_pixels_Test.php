<?php
class draw_text {
	private $text ;
	private $height_px;
	private $width_px;
	function __construct( string $text  ){
		$this->text = $text;
		$font = './fonts/courier.ttf';
		$font = realpath($font) ;
		$arr = imagettfbbox(10, 0.0, $font, $text);
		$this->height_px = $arr[1] - $arr[5];
		$this->width_px = $arr[4] - $arr[0];
		
		
	}
	
	function get_height( ) : int {
		return $this->height_px;
	}
	
	function get_width( ) : int {
		return $this->width_px;
	}
	
}
class string_size_in_pixels_Test extends PHPUnit\Framework\TestCase {
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
		
		$textobj = new draw_text($text);
		$this->assertEquals( 144, $textobj->get_width()  );
		$this->assertEquals( 13, $textobj->get_height()  );
	}
}

