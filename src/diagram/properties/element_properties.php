<?php
namespace diagram;

trait element_properties {
	private $type = "";
	private $type_draw;
	function set_type( string $type ){
		$this->type = $type;
		$this->type_draw = new draw_text($type);
	}
	function get_type() : string {
		return $this->type;
	}
	
	private $name = "";
	private $name_draw = "";
	function set_name( string $name ){
		$this->name = $name;
		$this->name_draw = new draw_text($name);
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
	
}