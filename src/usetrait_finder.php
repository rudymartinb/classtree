<?php
namespace src;

class usetrait_finder {
	use finder;
	
	function __construct( string $source ){
		$this->source = $source;
		
		$this->pattern  = "/";
		$this->pattern .= "(\s*(?:(use\s+|,)\s*(?<traitname>[a-zA-Z0-9_]*)))";
		$this->pattern .= "";
		$this->pattern .= "/ms";
		
		
		$this->matches($source);
	}
	
	function get_trait_name(): string {
		return $this->matches["traitname"][$this->current_key];
	}
	
}
?>