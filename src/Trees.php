<?php
namespace src; 

use function src\force_class;

class tree2 {
	
	function __construct(){
		
	}
	
	private $sources = [];
	private $current_key = 0;
	function more_elements() : bool {
		return count( $this->sources ) > $this->current_key;
	}
	
	function add_source( string $source ){
		$this->sources[] = $source;
	}
}
