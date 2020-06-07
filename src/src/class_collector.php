<?php
namespace src;
abstract class collector {
	protected $data = [];
	
	
	function __construct( collector $previous = null ){
		if( $previous !== null ){
			$this->data = $previous->data;
		}
	}
	
	function more_elements() : bool {
		return count( $this->data ) > $this->current_key;
	}
	function get() : Array {
		return $this->data[$this->current_key];
	}
	function get_count() : int {
		return count( $this->data );
	}
	
	protected $current_key = 0;
	function next(){
		$this->current_key ++;
	}
	
}

class class_collector extends collector {
	
	function get_name() : string {
		return $this->data[$this->current_key]["name"];
	}
	function get_extends() : string  {
		return $this->data[$this->current_key]["extends"];
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
				$func = [ "fnname" => $finder->get_function_name(), 
						"fnretval" => $finder->get_function_return_type(), 
						"params" => [] 
						
				];
				while( $finder->more_parameters() ){
					$func["params"][] = [ 
							"param_type" => $finder->get_parameter_type(), 
							"param_name" => $finder->get_parameter_name() 
							
					];
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
			
			$this->data[] = $class;
			$finder->next();
		}
	}
	
	/*
	 * SPY
	 *
	 */
	function get_namespace() : string {
		return $this->data[ $this->class_index ]["namespace"];
	}
	
	protected $class_index = null;
	protected $function_index = null;
	protected $param_index = null;
	function select_class( string $classname  ){
		foreach( $this->data as $key => $class ){
			if( $class["name"] == $classname ){
				$this->class_index = $key;
				$this->function_index = 0;
				$this->param_index = 0;
				return;
			}
		}
		$this->class_index = null;
	}
	
}