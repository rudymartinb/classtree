<?php
namespace src;

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
			$class["abstract"] = $finder->get_abstract();
			
			$class["final"] = $finder->get_final();
			
			// implements is a comma separated string
			$implements = $finder->get_implements();
			$array = explode( "," , $implements );
			foreach( $array as $key => $implements ){
				$array[ $key ] = [ "ifname" => trim( $implements ) ];
			}
			$class["implements"] = $array;
			
			
			$class["functions"] = [];
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
	 * SPY section for testing
	 * TODO: move to another class
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
	function is_final(): bool{
		return $this->data[ $this->class_index ]["final"] === "final";
	}
	function is_abstract(): bool{
		return $this->data[ $this->class_index ]["abstract"] === "abstract";
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
		return $this->data[ $this->class_index ]["functions"][ $this->function_index ][ "fnretval"];
	}
	function next_function(){
		$this->function_index ++;
		$this->param_index = 0;
	}
	
	// FUNCTIONS parameters section
	function more_parameters() : bool {
		return count( $this->data[ $this->class_index ]["functions"][ $this->function_index ][ "params"] ) > $this->param_index;
	}
	function get_function_parameter_type() : string {
		return $this->data[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ]["param_type"];
	}
	function get_function_parameter_name() : string {
		return $this->data[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ]["param_name"];
	}

	// USE TRAITS section
	private $usetrait_index = 0;
	function more_usetraits() : bool {
		return count( $this->data[ $this->class_index ][ "usetraits"] ) > $this->usetrait_index;
	}
	function get_usetrait_name() : string {
		return $this->data[ $this->class_index ][ "usetraits"][$this->usetrait_index]["usetrait_name"];
	}
	function next_usetrait() {
		return $this->usetrait_index ++;
	}

	// INTERFACES section
	private $implements_index = 0;
	function more_interfaces() : bool {
		return count( $this->data[ $this->class_index ][ "implements"] ) >$this->implements_index ;
	}
	function next_interface(){
		$this->implements_index ++;
	}
	function get_interface_name() : string {
		return $this->data[ $this->class_index ][ "implements"][ $this->implements_index ]["ifname"];
	}
	
	
	
}