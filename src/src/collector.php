<?php
namespace src;

abstract class collector {
	protected $data = [];
	function __construct( collector $previous = null ){
		if( $previous !== null ){
			$this->data = $previous->data;
		}
	}
	
	protected $current_key = 0;
	function next(){
		$this->current_key ++;
	}
	
	function more_elements() : bool {
		return count( $this->data ) > $this->current_key;
	}
	function get() : Array {
		return $this->data[$this->current_key];
	}
	function count() : int {
		return count( $this->data );
	}
	
	abstract function add_source( string $source );
	
	abstract function clone() : collector;
	
}
