<?php
namespace src;
class class_collector {

	function __construct( class_collector $previous = null ){
		if( $previous !== null ){
			$this->classes = $previous->classes;
		}
	}
	
	private $classes = [];

	private $current_key = 0;
	function next(){
		$this->current_key ++;
	}
	private $matches = [];
	function more_elements() : bool {
		return count( $this->classes ) > $this->current_key;
	}
	function get() : Array {
		return $this->classes[$this->current_key];
	}
	function get_name() : string {
		return $this->classes[$this->current_key]["name"];
	}
	function get_extends() : string  {
		return $this->classes[$this->current_key]["extends"];
	}
	
	function get_count() : int {
		return count( $this->classes );
	}
	
	function add_classes( string $source, string $namespace = "" ){
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
			
			$class["usetraits"] = [];
			while( $finder->more_traits() ){
				$class["usetraits"][] = [ "usetrait_name" => $finder->get_trait_name() ];
				$finder->next_trait();
			}
			
			$this->classes[] = $class;
			$finder->next();
		}
	}
	
	/*
	 * SPY
	 * 
	 */
	

	
}
class class_tree_builder extends tree_builder {

	protected $collector;
	function __construct(){
		$this->collector = new class_collector();
	}
	
	protected $classes = [] ;

	protected function resolve( string $parent = "" ) : Array {
		$tree = [];
		
		$collector = new class_collector( $this->collector );
		
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
			$tree[] = [
					"name" => $classname,
					"extends" => $extends,
					"children" => $children,
					"width" => max( $this->max_width( $children ), 1 ),
					"height" => $this->max_height( $children )+1
			];
			$collector->next();
		}
		return $tree;
	}


	function add_source( string $source ){
		$nsfinder = new namespace_finder($source);
		while($nsfinder->more_elements()){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->collector->add_classes( $body, $namespace );
			$nsfinder->next();
		}
	}
	
}
