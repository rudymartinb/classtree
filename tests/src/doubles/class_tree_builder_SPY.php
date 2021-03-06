<?php 
use src\class_tree_builder;
use src\class_collector;
use src\interface_tree_builder;
use src\interface_collector;

class class_tree_builder_SPY extends class_tree_builder {
	function get_collector() : class_collector {
		return $this->collector;
	}
	
	function get_num_classes() : int {
		return $this->collector->count();
	}
	
}

class interface_tree_builder_SPY extends interface_tree_builder {
	function get_collector() : interface_collector {
		return $this->collector;
	}
	
	function get_num_classes() : int {
		return $this->collector->count();
	}
	
}