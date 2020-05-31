<?php
namespace src;

class trait_finder {
	use finder;
	
	function __construct( string $source, string $namespace = "" ){
		$this->namespace = $namespace;
		
		$this->pattern  = "/^(?<original>";
		$this->pattern .= "(";
		
		// the extra enclosed subpattern
		// is necesary to avoid including the trailing space
		
		$this->pattern .= "(?:trait\s*)";
		$this->pattern .= "(?<traitname>[0-9a-zA-Z_]+)";
		
		// end of the declaration line
		$this->pattern .= "[^{]*)";
		$this->pattern .= ")";
		
		// TODO: probably the correct way would be to search for nested {}
		/*
		 * problem here is I can't search for the function keyword.
		 * and it may even get ugly if an annonymous class in embebbed
		 */
		$this->pattern .= "(?<body>";
		$this->pattern .= "((?!((?R)|^\s*interface\s*|^(\s*(abstract|final|))\s*\s*class\s*|^\s*namespace\s*)).)*";
		$this->pattern .= ")";

		$this->pattern .= "/ms";
		
		$this->matches($source);
	}
	
	
	function get_name() : string {
		return $this->matches["traitname"][ $this->current_key ];
	}
	
	function get_body() : string {
		return $this->matches["body"][ $this->current_key ];
	}
	
	/*
	 * functions section:
	 * it should create a private function finder object
	 * apply it to the body source
	 */
	private $function_finder;
	function has_functions() : bool {
		$body = $this->get_body();
		
		$this->function_finder = new function_finder($body);
		
		return $this->function_finder->more_elements();
	}
	
	function get_function_name() : string {
		return $this->function_finder->get_name();
	}
	function next_function(){
		return $this->function_finder->next();
	}
	
	// function parameters section
	function has_parameters() : bool {
		return $this->function_finder->has_parameters();
	}
	function get_parameter_name() : string {
		return $this->function_finder->get_parameter_name();
	}
	function get_parameter_type() : string {
		return $this->function_finder->get_parameter_type();
	}
	
	function next_parameter(){
		return $this->function_finder->next_parameter();
	}
	
	
}