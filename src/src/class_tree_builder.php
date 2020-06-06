<?php
namespace src;

abstract class tree_builder {
	
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

	function get_max_width(): int{
		return $this->max_width($this->tree);
	}
	function get_max_height(): int{
		return $this->tree[0]["height"];
	}
	
	private function get_tree( Array $classes, string $parent = "" ){
		$tree = [];
		
		foreach( $classes as $class ){

			
			if( $parent !== "" ){
				if( ! $class->is_child_of( $parent ) ){
					continue;
				}
			} else {
				// this is necessary to avoid adding subclases
				// to the top of the tree
				// as if they were parent clases
				if( $class->is_child() ){
					continue;
				}
			}
			
			/* generate new element to be added to the tree
			 * by doing a recursive call,
			 * we ensure the bottom order is then analized to the top
			 */
			$name = $class->get_name();
			$type = $class->get_type();
			
			$children = $this->get_tree( $classes, $name );
			
			$extends = $class->get_extends();
			$implements = $class->get_implements();
			$abstract = $class->get_abstract();
			$final = $class->get_final();
			$namespace = $class->get_namespace();
			
			$tree[] = [
					"name" => $name,
					"type" => $type,
					"extends" => $extends,
					"childrens" => $children,
					"width" => max( $this->max_width( $children ), 1 ),
					"height" => $this->max_height( $children )+1,
					"implements" => $implements,
					"abstract" => $abstract,
					"final" => $final,
					"namespace" => $namespace
			];
		}
		return  $tree;
	}
	
// 	function total_width() : int {
// 		return $this->max_width($this->trees);
// 	}
	
	private function max_width( Array $trees ) : int {
		$actual = 0;
		foreach( $trees as $tree ){
			$actual += $tree["width"];
		}
		return $actual;
	}
	
	
	/* the maximum height of all parent tree
	 */
// 	function total_height() : int {
// 		return $this->max_height($this->trees);
// 	}
	
	private function max_height( Array $trees ) : int {
		$maxheight = 0;
		foreach( $trees as $tree ){
			$actual = $tree["height"];
			if( $actual > $maxheight ){
				$maxheight = $actual;
			}
		}
		return $maxheight;
	}
	
	
	
	private $tree = [];
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