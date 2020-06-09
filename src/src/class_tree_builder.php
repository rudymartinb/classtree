<?php
namespace src;

use tree\tree;

class class_tree_builder extends tree_builder {

	protected $collector;
	function __construct(){
		$this->collector = new class_collector();
		$this->newcollector = function(){
			return new class_collector( $this->collector );
		};
	}
	
	function get_new_collector() : collector {
		$func = $this->newcollector;
		return $func();
	}

	
}
