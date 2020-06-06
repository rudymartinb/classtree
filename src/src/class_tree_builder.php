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
	
	
}
/*
 * the intended goal of this class is to generate 
 * the virtual tree of classes and interfaces
 */
class class_tree_builder extends tree_builder {

	private $classes = [] ;
	function get_num_classes() : int {
		return count( $this->classes );
	}


	
	
	function resolve_class_hierarchy( string $parent = "" ) {
		$this->tree = $this->resolve();
	}
	private function resolve( string $parent = "" ) : Array {
		$tree = [];
		foreach( $this->classes as $class ){
			$name = $class["name"];
			$extends = $class["extends"];
			
			if( $parent !== "" ){
				/* we are looking for specific children
				 */
				if( $extends != $parent ) {
					continue;
				}
			} else {
				/* we are looking for parents classes only
				 */
				if( $extends !== "" ){
					continue;
				}
			}
			
			$children = $this->resolve( $name );
			
			$tree[] = [
					"name" => $name,
					"extends" => $extends,
					"children" => $children,
					"width" => max( $this->max_width( $children ), 1 ),
					"height" => $this->max_height( $children )+1
			];
			
		}
		return $tree;

	}

	/* I just realized there's 
	 * no point in adding extra info to the tree structure
	 * we can just look into $classes for that
	 */
	function add_source( string $source ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$class = [];
			$class["name"] = $finder->get_name();
			$class["extends"] = $finder->get_extends();
			$class["children"] = [];
			$class["width"] = 1;
			$class["height"] = 1;
			$this->classes[] = $class;
			$finder->next();
		}
	}
}