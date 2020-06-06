<?php
namespace src;

/*
 * the intended goal of this class is to generate 
 * the virtual tree of classes and interfaces
 */
class tree_builder {

	private $classes = [] ;
	

	function add_source( string $source ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$class = [];
			$class[] = [ "name" => $finder->get_name() ];
			$this->classes[] = $class;
			$finder->next();
		}
	}
	function get_num_classes() : int {
		return count( $this->classes );
	}
}