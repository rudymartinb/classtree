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

	protected $classes = [] ;
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
	
	/*
	 * TODO: move all non-production code to a subclass and test from there
	 */
	protected $class_index = null;
	protected $function_index = null;
	protected $param_index = null;
	function select_class( string $classname  ){
		foreach( $this->classes as $key => $class ){
			if( $class["name"] == $classname ){
				$this->class_index = $key;
				$this->function_index = 0;
				$this->param_index = 0;
				return; 
			}
		}
		$this->class_index = null;
	}

	function get_function_name() : string {
		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "fnname"];
	}
	function get_function_return_type() : string {
		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "fnretval"];
	}
	function more_parameters() : bool {
		return count( $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "params"] ) > $this->param_index;
	}
	function get_function_parameter_type() : string {
		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ]["param_type"];
	}
	function get_function_parameter_name() : string {
		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ]["param_name"];
	}
	
	function next_function(){
		$this->function_index ++;
		$this->param_index = 0;
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
			while( $finder->more_functions() ){
				$func = [ "fnname" => $finder->get_function_name(), "fnretval" => $finder->get_function_return_type(), "params" => [] ];
				while( $finder->more_parameters() ){
					$func["params"][] = [ "param_type" => $finder->get_parameter_type(), "param_name" => $finder->get_parameter_name() ];
					$finder->next_parameter();
				}
				$class["functions"][] = $func;
				$finder->next_function();
			}
			$this->classes[] = $class;
			$finder->next();
		}
	}
}

class class_tree_builder_SPY extends class_tree_builder {
	
	function get_namespace() : string {
		return $this->classes[ $this->class_index ]["namespace"];
	}
	
}