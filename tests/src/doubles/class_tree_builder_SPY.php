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
	
}