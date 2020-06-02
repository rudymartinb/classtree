<?php
namespace diagram;

/*
 * element = class, interface or trait on a diagram
 * 
 * just an rectangle with some text
 * type should go first unless its a class
 * name (with modifiers like abstract/final?)
 * interfaces unless present on the diagram
 * extends unless present on the diagram
 * traits always for now.
 * list of functions names (at least for now)
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