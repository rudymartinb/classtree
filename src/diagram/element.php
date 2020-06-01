<?php
namespace diagram;
class element {
	private $placed = false;
	function is_placed() : bool{
		return $this->placed;
	}
	
	private $type = "";
	function set_type( string $type ){
		$this->type = $type;
	}
	function get_type() : string {
		return $this->type;
	}
	
	private $name = "";
	function set_name( string $name ){
		$this->name = $name;
	}
	function get_name() : string {
		return $this->name;
	}

	private $namespace = "";
	function set_namespace( string $namespace ){
		$this->namespace  = $namespace;
	}
	function get_namespace() : string {
		return $this->namespace;
	}
	private $x, $y;
	function set_position( int $x, int $y ){
		$this->x = $x;
		$this->y = $y;
		$this->placed = true;
	}
	
}