<?php
namespace src;

class interface_tree_builder extends tree_builder {
	protected $collector;
	function __construct(){
		$this->collector = new interface_collector();
	}
	
	protected function resolve(string $parent = "") {
	}

	public function add_source(string $source) {
	}

	
}