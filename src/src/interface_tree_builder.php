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
 

	public function add_source(string $source) {
		$nsfinder = new namespace_finder($source);
		while($nsfinder->more()){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->collector->add_classes( $body, $namespace );
			$nsfinder->next();
		}
	}

	
}