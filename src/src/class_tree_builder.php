<?php
namespace src;

use tree\tree;

class class_tree_builder extends tree_builder {

	protected $collector;
	function __construct(){
		$this->collector = new class_collector();
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
			
			$tree_item = new tree( $classname );
			$tree_item->set_extends($extends);
			$tree_item->set_children($children);
			$tree_item->set_width( max( $this->max_width( $children ), 1 ) );
			$tree_item->set_height( $this->max_height( $children )+1 );
			$tree[] = $tree_item;
					
			$collector->next();
		}
		return $tree;
	}

	function add_source( string $source ){
		$nsfinder = new namespace_finder($source);
		while( $nsfinder->more() ){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->collector->add_source( $body, $namespace );
			$nsfinder->next();
		}
	}

	
}
