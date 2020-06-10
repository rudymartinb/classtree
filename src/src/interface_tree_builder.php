<?php
namespace src;


class interface_tree_builder extends tree_builder {
	
	function __construct(){
		$this->collector = new interface_collector();
	}
	
	function get_new_collector() : collector {
		return new interface_collector( $this->collector );
	}
 

	
}