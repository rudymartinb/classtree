<?php 
use src\class_tree_builder;
use src\class_collector;

class class_tree_builder_SPY extends class_tree_builder {
	function get_collector() : class_collector {
		return $this->collector;
	}
	
	function get_num_classes() : int {
		return $this->collector->get_count();
	}
	
	
// 	protected $class_index = null;
// 	protected $function_index = null;
// 	protected $param_index = null;
// 	function select_class( string $classname  ){
// 		foreach( $this->classes as $key => $class ){
// 			if( $class["name"] == $classname ){
// 				$this->class_index = $key;
// 				$this->function_index = 0;
// 				$this->param_index = 0;
// 				return;
// 			}
// 		}
// 		$this->class_index = null;
// 	}
	
// 	function get_function_name() : string {
// 		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "fnname"];
// 	}
// 	function get_function_return_type() : string {
// 		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "fnretval"];
// 	}
// 	function more_parameters() : bool {
// 		return count( $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "params"] ) > $this->param_index;
// 	}
// 	function get_function_parameter_type() : string {
// 		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ]["param_type"];
// 	}
// 	function get_function_parameter_name() : string {
// 		return $this->classes[ $this->class_index ]["functions"][ $this->function_index ][ "params"][ $this->param_index ]["param_name"];
// 	}
	
// 	function next_function(){
// 		$this->function_index ++;
// 		$this->param_index = 0;
// 	}
	
// 	private $usetrait_index = 0;
// 	function more_usetraits() : bool {
// 		return count( $this->classes[ $this->class_index ][ "usetraits"] ) > $this->usetrait_index;
// 	}
// 	function get_usetrait_name() : string {
// 		return $this->classes[ $this->class_index ][ "usetraits"][$this->usetrait_index]["usetrait_name"];
// 	}
// 	function next_usetrait() {
// 		return $this->usetrait_index ++;
// 	}
	
	
}