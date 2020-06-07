<?php
namespace src;

class interface_tree_builder extends tree_builder {
	protected $collector;
	function __construct(){
		$this->collector = new interface_collector();
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
			$tree[] = [
					"name" => $interfacename,
					"extends" => $extends,
					"children" => $children,
					"width" => max( $this->max_width( $children ), 1 ),
					"height" => $this->max_height( $children )+1
			];
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