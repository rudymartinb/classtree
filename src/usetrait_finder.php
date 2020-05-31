<?php
namespace src;

class usetrait_finder {
	use finder;

	function __construct( string $source ){
		$this->source = $source;
		
		$this->pattern  = "/";
		$this->pattern .= "(?:use\s+)(?<traitname>[a-zA-Z0-9_,\s]*)";
		$this->pattern .= "[^;{]*";
		$this->pattern .= "/mxs";
		

		/* HACK: split multiple trait names
		 */
		$matches = $this->matches($source);
		$result = [];
		foreach ($matches["traitname"] as $match){
			$arr = explode(",", $match );
			$result = array_merge( $result, $arr );
		}
		
		$this->matches["traitname"] = $result;
	}
	
	function get_trait_name(): string {
		return trim( $this->matches["traitname"][$this->current_key] );
	}
	
}

?>