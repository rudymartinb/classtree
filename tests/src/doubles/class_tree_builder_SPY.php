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