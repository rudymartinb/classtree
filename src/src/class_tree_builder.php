<?php
namespace src;

use tree\tree;

class class_tree_builder extends tree_builder {

	protected $collector;
	function __construct(){
		$this->collector = new class_collector();
		$this->newcollector = function(){
			return new class_collector( $this->collector );
		};
	}
	
	function get_new_collector() : collector {
		$func = $this->newcollector;
		return $func();
	}
	

	protected function resolve( string $parent = "" ) : Array {
		// by doing this we keep the internal pointer
		// separated on each recursive call.
		$collector = new class_collector( $this->collector );
		
		$tree = [];
		while( $collector->more_elements() ){
			$classname = $collector->get_name();
			$extends = $collector->get_extends();
			
			if( $parent !== "" ){
				if( $extends != $parent ) {
					$collector->next();
					continue;
				}
			} else {
				if( $extends !== "" ){
					$collector->next();
					continue;
				}
			}

			$children = $this->resolve( $classname );
			
			$node = new tree( $classname );
			$node->set_extends($extends);
			$node->set_children($children);
			$node->set_width( max( $this->max_width( $children ), 1 ) );
			$node->set_height( $this->max_height( $children )+1 );
			$tree[] = $node;
					
			$collector->next();
		}
		return $tree;
	}

	
}
