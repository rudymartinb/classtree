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
		$this->pattern .= "(\s*function\s+)";
		$this->pattern .= "(?<name>[a-zA-Z0-9_]*)";
		$this->pattern .= "\(";
		$this->pattern .= "\s*\)\s*";
		
		
		$this->pattern .= "/mxs";
		
		$this->matches($source);
	}
	
	function get_name(): string {
		return $this->matches["name"][$this->current_key];
	}
	function more_parameters() : bool {
		return false;
	}
	
}