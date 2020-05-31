<?php
namespace diagram;
use src\class_finder;

class diagram {
	function get_num_elements() : int {
		return count( $this->elements );
	}
	
	private $elements = [];
	function add_source( string $source ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$element = new element();
			$element->set_name($finder->get_name());
			$element->set_namespace($finder->get_namespace());
			$this->elements[] = $element;
			$finder->next();
		}
	}
	
	function get_element_by_name( string $name ) : element {
		foreach( $this->elements as $element ){
			if( $element->get_name() === $name ){
				return $element;
			}
		}
		// this should throw an exception
		return null;
	}
	
}