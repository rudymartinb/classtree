<?php
namespace src;

trait finder {
	private $pattern;
	private $source = "";
	
	/*
	 * understanding $matches firt index key:
	 * 0 = represents the lines of code matched
	 * 1/nsname = name of the namespace found.
	 * original = first line of code of the namespace matched
	 * body = just the code that follows up to the next namespace, if any
	 *
	 */
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