<?php
namespace diagram;
class element {
	function is_placed() : bool{
		return false;
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
	
}