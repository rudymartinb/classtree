<?php
namespace src;

class usetrait_finder {
	use finder;
	
	function __construct( string $source ){
		$this->source = $source;
		
		$this->pattern  = "/^";
		$this->pattern .= "(\s*use\s+)";
		$this->pattern .= "(?<traitname>[a-zA-Z0-9_]*)";
		$this->pattern .= "\s*";
		$this->pattern .= "/ms";
	
		
		$this->matches($source);
	}
}
?>