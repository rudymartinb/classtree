<?php
namespace src;

use tree\tree;

class interface_tree_builder extends tree_builder {
	protected $collector;
	
	private $newcollector;
	function __construct(){
		$this->collector = new interface_collector();
		$this->newcollector = function(){
			return new interface_collector( $this->collector );
		};
	}
	
	function get_new_collector() : collector {
		$func = $this->newcollector;
		return $func(); 
	}
 

	
}