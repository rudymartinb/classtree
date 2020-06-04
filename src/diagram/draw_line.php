<?php
namespace diagram;

class draw_line implements component {
	
	private $draw_function;
	function set_draw_function( Callable $function ){
		$this->draw_function = $function;
	}
	
	function draw( $img ){
		
		if( $img === null ){
			return;
		}
		
		$function = $this->draw_function;
		
		$function( $img );
		
	}
	
	
	function __construct(){
		
		$this->draw_function = function( $img  ){
			// TODO: replace with the actual function all
			$this->color["white"] = imagecolorallocate($img, 255,   255,  255);
			$this->color["black"] = imagecolorallocate($img, 0,   0,  0);
			$this->color["gray"]   = imagecolorallocate($img, 240,   240,  240);
			
			imagerectangle($img, $this->x, $this->y, $this->x+$this->width, $this->y, $this->color["black"] );
		};
	}
	
	private $width = 0;
	function set_width( int $width ){
		$this->width = $width;
	}
	function get_width(): int {
	}

	function get_x(): int {
	}

	function get_y(): int {
	}

	function set_xy(int $x, int $y) {
		$this->x = $x;
		$this->y = $y;
	}

	function get_height(): int {
		return 11;
	}

	
}
