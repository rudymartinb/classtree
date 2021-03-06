<?php
namespace src;


class class_tree_builder extends tree_builder {
	
	function __construct(){
		$this->collector = new class_collector();
		$this->ifcollector = new interface_collector();
	}
	
	function get_new_collector() : collector {
		return new class_collector( $this->collector );
	}
	
}
