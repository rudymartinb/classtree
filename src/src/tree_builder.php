<?php
namespace src;

/*
 * the intended goal of this class is to generate 
 * the virtual tree of classes and interfaces
 */
class tree_builder {

	private $classes = [] ;
	function get_num_classes() : int {
		return count( $this->classes );
	}

	function get_max_width(): int{
		return count( $this->classes );
	}
	function get_max_height(): int{
		return 1;
	}
	

	function add_source( string $source ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$class = [];
			$class["name"] = $finder->get_name();
			$this->classes[] = $class;
			$finder->next();
		}
	}
}