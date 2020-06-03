<?php
namespace diagram;


class draw_text implements component {
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