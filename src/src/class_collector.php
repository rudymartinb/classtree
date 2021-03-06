<?php
namespace src;

class class_collector extends collector {
	
	function clone() : collector {
		return new class_collector( $this );
	}
	function get_name() : string {
		return $this->data[$this->current_key]["name"];
	}
	function get_extends() : string  {
		return $this->data[$this->current_key]["extends"];
	}
	function get_data() : Array {
		return $this->data;
	}
	
	function get_implements(): Array {
		return $this->data[$this->current_key]["implements"];
	}
	
	
	private $index_array = [];
	function add_source( string $source, string $namespace = "" ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$class = [];
			$name = $finder->get_name();
			$extends = $finder->get_extends();
			$abstract = $finder->get_abstract();
			$final = $finder->get_final();
			
			$class["name"] = $name;
			$class["extends"] = $extends;
			$class["namespace"] = $namespace;
			$class["abstract"] = $abstract;
			
			$class["final"] = $final;
			
			// implements is a comma separated string

			$imp = $finder->get_implements();
			$class["implements"] = [];
			if( trim( $imp ) !== "" ){
				$array = explode( "," , $imp );
				foreach( $array as $key => $implements ){
					$array[ $key ] = [ "ifname" => trim( $implements ) ];
				}
				$class["implements"] = $array;
			}
			
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
			$this->index_array[ $name ] = count( $this->data )-1;
			
			$finder->next();
		}
	}
	
	function get_index() : Array {
		return $this->index_array;
	}
	function add_node( Array $node ){
		$this->data[] = $node;
		$this->index_array[ $node["name"]] = count( $this->data )-1;
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
	
	function select( string $classname  ) : int {
		$this->class_index = $this->index_array[ $classname ];
		$this->function_index = 0;
		$this->param_index = 0;
		return $this->class_index;
	}
	
	function is_final(): bool{
		return $this->data[ $this->class_index ]["final"] === "final";
	}
	function is_abstract(): bool{
		return $this->data[ $this->class_index ]["abstract"] === "abstract";
	}
	

	// FUNCTIONS section
	private function function_key( string $tag ){
		return $this->data[ $this->class_index ]["functions"][ $this->function_index ][ $tag ];
	}
	
	function get_function_name() : string {
		return $this->function_key( "fnname" );
	}
	
	function get_function_static() : string {
		return $this->function_key("fnstatic");
	}
	
	function get_function_access() : string {
		return $this->function_key("fnkeyword");
	}
	
	function get_function_return_type() : string {
		return $this->function_key("fnretval");
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