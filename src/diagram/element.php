<?php
namespace diagram;

/*
 * element = class, interface or trait
 */
class element {
	use element_properties;
	
	private $placed = false;
	function get_height() : int {
		return 65;
	}

	function is_placed() : bool{
		return $this->placed;
	}
	
	private $x, $y;
	function set_position( int $x, int $y ){
		$this->x = $x;
		$this->y = $y;
		$this->placed = true;
	}
	
}