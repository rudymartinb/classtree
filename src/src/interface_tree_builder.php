<?php
namespace src;

use tree\tree;

class interface_tree_builder extends tree_builder {
	protected $collector;
	
	private $newcollector;
	function __construct(){
		$this->collector = new interface_collector();
		$this->newcollector = function(){
			return new interface_collector( $this->collector );
		};
	}
	
	private function get_new_collector() : interface_collector {
		$func = $this->newcollector;
		return $func(); 
	}
	
	protected function resolve(string $parent = "") {
		$tree = [];
		
		// by doing this we keep the internal pointer
		// separated on each recursive call.
		$collector = new interface_collector( $this->collector );
		
		while( $collector->more_elements() ){
			
			$interfacename = $collector->get_name();
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
			$children = $this->resolve( $interfacename );
			
			$node = new tree( $interfacename );
			$node->set_extends($extends);
			$node->set_children($children);
			$node->set_width( max( $this->max_width( $children ), 1 ) );
			$node->set_height( $this->max_height( $children )+1 );
			$tree[] = $node;
			$collector->next();
		}
		return $tree;
	}

	public function add_source(string $source) {
		$nsfinder = new namespace_finder($source);
		while($nsfinder->more()){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->collector->add_classes( $body, $namespace );
			$nsfinder->next();
		}
	}

	
}