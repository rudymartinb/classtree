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
	private $name_draw;
	function set_name( string $name ){
		$this->name = $name;
		$this->name_draw = new draw_text($name);
	}
	function get_name() : string {
		return $this->name;
	}
	
	private $namespace = "";
	private $namespace_draw;
	function set_namespace( string $namespace ){
		$this->namespace  = $namespace;
		$this->namespace_draw = new draw_text($namespace);
	}
	function get_namespace() : string {
		return $this->namespace;
	}
	
	private $extends = "";
	private $extends_draw;
	function set_extends( string $extends ){
		$this->extends = $extends;
		$this->extends_draw = new draw_text($extends);
	}
	function get_extends() : string {
		return $this->extends;
	}
	
	// string of comma separated interfaces
	private $implements = "";
	private $implements_draw;
	function set_implements( string $implements ){
		$this->implements = $implements;
		$this->implements_draw = new draw_text($implements);
	}
	function get_implements() : string {
		return $this->implements;
	}
	
	private $usetraits = "";
	private $usetraits_draw = "";
	function set_usetraits($usetraits) {
		$this->usetraits = $usetraits;
		$this->usetraits_draw = new draw_text($usetraits);
	}
	function get_usetraits() {
		return $this->usetraits;
	}
	private $functions = [];
	
	function get_functions() {
		return $this->functions;
	}
	
	function set_functions($functions) {
		$this->functions = $functions;
	}
	
}