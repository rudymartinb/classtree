<?php
namespace src;

use tree\tree;

class interface_tree_builder extends tree_builder {
	
	private $newcollector;
	function __construct(){
		$this->collector = new interface_collector();
		$this->newcollector = function(){
			return new interface_collector( $this->collector );
		};
	}
	
	function get_new_collector() : collector {
// 		$func = $this->newcollector;
		return new interface_collector( $this->collector );
	}
 

	
}