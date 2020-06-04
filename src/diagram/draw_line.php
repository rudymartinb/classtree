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
		};
	}
	
	function get_width(): int {
	}

	function get_x(): int {
	}

	function get_y(): int {
	}

	function set_xy(int $x, int $y) {
	}

	function get_height(): int {
		return 1;
	}

	
}