<?php
namespace src;

class parameters_finder {
	use finder;
	function __construct( string $source ){
		$this->pattern  = '/(?<partype>[a-zA-Z0-9_]*)';
		$this->pattern .= '\s*\&{0,1}\s*'; // is by reference ?
		$this->pattern .= '\$(?<parname>[a-zA-Z0-9_]*)/mxs';
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$this->matches = $matches;
			
	}
	function get_name() : string {
		if( $this->matches["parname"][ $this->current_key ] === null )
			return "";
		return $this->matches["parname"][ $this->current_key ];
	}
	
	function get_type() : string {
		return $this->matches["partype"][ $this->current_key ];
	}
	
}