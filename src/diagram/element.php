<?php
namespace diagram;

/*
 * element = class, interface or trait
 */
class element {
	private $placed = false;
	
	function get_height() : int {
		return 65;
	}

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

	private $extends = "";
	function set_extends( string $extends ){
		$this->extends = $extends;
	}
	function get_extends() : string {
		return $this->extends;
	}

	// string of comma separated interfaces
	private $implements = "";
	function set_implements( string $implements ){
		$this->implements = $implements;
	}
	function get_implements() : string {
		return $this->implements;
	}
	
	private $usetraits = "";
	function get_usetraits() {
		return $this->usetraits;
	}
	function set_usetraits($usetraits) {
		$this->usetraits = $usetraits;
	}
	
	private $functions = [];
	
	function get_functions() {
		return $this->functions;
	}
	
	function set_functions($functions) {
		$this->functions = $functions;
	}
	
	private $x, $y;
	function set_position( int $x, int $y ){
		$this->x = $x;
		$this->y = $y;
		$this->placed = true;
	}
	
}