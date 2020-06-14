<?php
namespace src;

class interface_collector extends collector {
	function clone() : collector {
		return new interface_collector( $this );
	}
	
	function get_name() : string {
		return $this->data[$this->current_key]["name"];
	}
	function get_extends() : string  {
		return $this->data[$this->current_key]["extends"];
	}
	
	
	
	function add_source( string $source, string $namespace = "" ){
		$finder = new interface_finder($source);
		while( $finder->more_elements() ){
			$interface = [];
			$interface["name"] = $finder->get_name();
			$interface["extends"] = $finder->get_extends();
			$interface["namespace"] = $namespace;
			
			
			$interface["functions"] = [];
			while( $finder->more_functions() ){
				$func = [ "fnname" => $finder->get_function_name(),
						"fnretval" => $finder->get_function_return_type(),
						"fnstatic" => $finder->get_function_static(),
						"fnkeyword" => $finder->get_function_keyword(),
						"params" => []
						
				];
				while( $finder->more_parameters() ){
					$func["params"][] = [
							"param_type" => $finder->get_parameter_type(),
							"param_name" => $finder->get_parameter_name()
							
					];
					$finder->next_parameter();
				}
				$interface["functions"][] = $func;
				$finder->next_function();
			}
			
			$this->data[] = $interface;
			$finder->next();
		}
	}
	
	/*
	 * SPY section for testing
	 * TODO: move to another class ?
	 */
	function get_namespace() : string {
		return $this->data[ $this->class_index ]["namespace"];
	}
	protected $class_index = null;
	protected $function_index = null;
	protected $param_index = null;
	function select( string $classname  ){
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
	
	
	// FUNCTIONS section
	private function thisfn( string $tag ){
		return $this->data[ $this->class_index ]["functions"][ $this->function_index ][ $tag ];
	}
	
	function get_function_name() : string {
		return $this->thisfn( "fnname" );
	}
	
	function get_function_static() : string {
		return $this->thisfn("fnstatic");
	}
	
	function get_function_keyword() : string {
		return $this->thisfn("fnkeyword");
	}
	
	function get_function_return_type() : string {
		return $this->thisfn("fnretval");
	}
	
	function next_function(){
		$this->function_index ++;
		$this->param_index = 0;
	}
	
	// FUNCTIONS parameters section
	function more_parameters() : bool {
		return count( $this->data[ $this->class_index ]["functions"][ $this->function_index ][ "params"] ) > $this->param_index;
	}
	
	private function thisparam( string $tag ) : string {
		return $this->data[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ][ $tag ];
	}
	
	function get_function_parameter_type() : string {
		return $this->thisparam( "param_type" );
	}
	function get_function_parameter_name() : string {
		return $this->thisparam( "param_name" );
	}
	
}