<?php
namespace src;

trait finder {
	private $pattern;
	private $source = "";
	
	private $current_key = 0;
	function next(){
		$this->current_key ++;
	}
	private $matches = [];
	function more_elements() : bool {
		return count( $this->matches[ 0 ] ) > $this->current_key;
	}
	
	function matches( string $source ) : Array {
		$this->source = $source;
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$this->matches = $matches;
		return $matches;
	}
	
}