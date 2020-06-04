<?php
namespace diagram;


class draw_text implements component {
	protected $text ;
	protected $height_px;
	protected $width_px;
	
	private $draw_function;
	function set_draw_function( Callable $function ){
		$this->draw_function = $function;
	}
	
	function draw( $img ){
		
		if( $img === null ){
			return;
		}
		
		putenv('GDFONTPATH=' . realPath('fonts'));
		$font = './fonts/courier.ttf';
		$font = realpath($font) ;
		$function = $this->draw_function;
		
		$function( $img, $font );

	}
	
	
	function __construct( string $text  ){
		$this->draw_function = function( $img, $font ){
			\imagettftext($img, 10,0.0, $this->x, $this->y, $this->color["black"] , $font, $this->text);
		};
		
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
	private $x = 0;
	private $y = 0;
	function set_xy(int $x, int $y) {
		$this->x = $x;
		$this->y = $y;
	}
	
	function get_x(): int {
		return $this->x;
	}
	
	function get_y(): int {
		return $this->y;
	}
	

	
}