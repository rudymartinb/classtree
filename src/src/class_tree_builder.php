<?php
namespace src;

use tree\tree;

/* now
 * we could entirely make this file disappear 
 * by passing the collector class to the constructor
 * and change the base class to a normal class.
 */
class class_tree_builder extends tree_builder {
	
	function __construct(){
		$this->collector = new class_collector();
	}
	
	function get_new_collector() : collector {
		return new class_collector( $this->collector );
	}

	
}
