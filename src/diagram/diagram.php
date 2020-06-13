<?php
namespace diagram;
use src\class_tree_builder;

class diagram {
	
	private $class_tree;
	function __construct(){
		$this->class_tree = new class_tree_builder();
	}
	function add_source( string $source ){
		
		$this->class_tree->add_source($source);
		
		
	}
	function get_width() : int {
		return $this->class_tree->get_max_width();
	}
	function get_height() : int {
		return $this->class_tree->get_max_height();
	}
	function resolve_hiearchy(){
		$this->class_tree->resolve_hierarchy();
	}

	
	function draw(){
			
		$this->class_tree->draw( $this->img );
		
		
		
	}
	
	
	
}