<?php
namespace src;
class function_finder {
	use finder;
	
	function __construct( string $source ){
		$this->source = $source;
		
		/* for the namespace keyword
		 * then add all the code up to the next keyword.
		 *
		 * TODO: test this against a windows newline character file
		 */
		$this->pattern  = "/^";
		$this->pattern .= "function";
		$this->pattern .= "/mxs";
		
		$this->matches($source);
	}
	
}