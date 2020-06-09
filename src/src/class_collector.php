<?php
namespace src;
use src\class_;

// class class_ {
// 	private $name = "";
// 	private $extends = "";
// 	private $abstract = "";
// 	private $final = "";
// 	private $implements = "";
// 	private $functions = [];
// 	private $usetraits = [];
// 	private $namespace = "";
// 	function __construct( string $name ){
// 		$this->name = $name;
// 	}
// 	function set_namespace( string $namespace ){
// 		$this->namespace = $namespace;
// 	}
// 	function get_namespace() : string {
// 		return $this->namespace;
// 	}
	
// 	function get_name() : string {
// 		return $this->name;
// 	}

	
// 	function set_extends( string $extends) {
// 		$this->extends = $extends;
// 	}
// 	function get_extends() : string {
// 		return $this->extends;
// 	}

// 	function get_abstract() : string {
// 		return $this->abstract;
// 	}

// 	function get_final() : string {
// 		return $this->final;
// 	}

// 	function get_implements() : string {
// 		return $this->implements;
// 	}

// 	function get_functions() : Array {
// 		return $this->functions;
// 	}

// 	function get_usetraits() : Array {
// 		return $this->usetraits;
// 	}

// 	function set_name( string $name) {
// 		$this->name = $name;
// 	}

// 	function set_abstract( string $abstract) {
// 		$this->abstract = $abstract;
// 	}

// 	function set_final( string $final) {
// 		$this->final = $final;
// 	}

// 	function set_implements( string $implements) {
// 		$this->implements = $implements;
// 	}

// 	function set_functions($functions) {
// 		$this->functions = $functions;
// 	}

// 	function set_usetraits($usetraits) {
// 		$this->usetraits = $usetraits;
// 	}

	
// }
class class_collector extends collector {
	
	function get_name() : string {
		return $this->data[$this->current_key]["name"];
	}
	function get_extends() : string  {
		return $this->data[$this->current_key]["extends"];
	}
	function get_data() : Array {
		return $this->data;
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
			$this->index_array[ $name ] = count( $this->data )-1;
			
			$finder->next();
		}
	}
	
	function get_index() : Array {
		return $this->index_array;
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