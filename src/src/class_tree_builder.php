<?php
namespace src;

abstract class tree_builder {
	protected $tree = [];
	
	function get_max_width(): int{
		return $this->max_width($this->tree);
	}
	function get_max_height(): int{
		return $this->tree[0]["height"];
	}
	
	protected function max_width( Array $trees ) : int {
		$actual = 0;
		foreach( $trees as $tree ){
			$actual += $tree["width"];
		}
		return $actual;
	}
	
	protected function max_height( Array $trees ) : int {
		$maxheight = 0;
		foreach( $trees as $tree ){
			$actual = $tree["height"];
			if( $actual > $maxheight ){
				$maxheight = $actual;
			}
		}
		return $maxheight;
	}
	
	function resolve_class_hierarchy( string $parent = "" ) {
		$this->tree = $this->resolve();
	}
	
	abstract protected function resolve();
	abstract function add_source( string $source );
}

class class_tree_builder extends tree_builder {

	private $classes = [] ;
	function get_num_classes() : int {
		return count( $this->classes );
	}
	
	protected function resolve( string $parent = "" ) : Array {
		$tree = [];
		foreach( $this->classes as $class ){
			$classname = $class["name"];
			$extends = $class["extends"];
			
			if( $parent !== "" ){
				if( $extends != $parent ) {
					continue;
				}
			} else {
				if( $extends !== "" ){
					continue;
				}
			}
			
			$children = $this->resolve( $classname );
			$tree[] = [
					"name" => $classname,
					"extends" => $extends,
					"children" => $children,
					"width" => max( $this->max_width( $children ), 1 ),
					"height" => $this->max_height( $children )+1
			];
		}
		return $tree;
	}
	
	private $class_index = null;
	function select_class( string $classname  ){
		foreach( $this->classes as $key => $class ){
			if( $class["name"] == $classname ){
				$this->class_index = $key;
				return; 
			}
		}
		$this->class_index = null;
	}
	
	function get_namespace() : string {
		return $this->classes[ $this->class_index ]["namespace"];
	}

	function add_source( string $source ){
		$nsfinder = new namespace_finder($source);
		$found = false;
		while($nsfinder->more_elements()){
			$found = true;
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->add_class( $body, $namespace );
			$nsfinder->next();
		}
		if( !$found ){
			$this->add_class($source );
		}
	}
	private function add_class( string $source, string $namespace = "" ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$class = [];
			$class["name"] = $finder->get_name();
			$class["extends"] = $finder->get_extends();
			$class["namespace"] = $namespace;
			$class["functions"] = [];
// 			while( $finder->more_functions() ){
// // 				$func = [ "fnname" => $finder->get_function_name(), "fnretval" => $finder-> ];
// // 				$class["functions"][] = $func;   
// 			}
			$this->classes[] = $class;
			$finder->next();
		}
	}
}