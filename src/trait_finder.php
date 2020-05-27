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
		$this->pattern .= "(?<body>";
		$this->pattern .= "((?!((?R)|interface |class |namespace )).)*";
		$this->pattern .= ")";
		
		// body business
		
		$this->pattern .= "/ms";
		
		$this->matches($source);
	}
	
	
	function get_name() : string {
		return $this->matches["traitname"][ $this->current_key ];
	}
	
	
}