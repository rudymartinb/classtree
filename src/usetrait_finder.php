<?php
namespace src;

class usetrait_finder {
	use finder;

	function __construct( string $source ){
		$this->source = $source;
		
		// /(?:use\s+)(?<traitname>[a-zA-Z0-9_,\s]*)[^;{]*/mxs

		$this->pattern  = "/";
		$this->pattern .= "(?:use\s+)(?<traitname>[a-zA-Z0-9_,\s]*)";
		$this->pattern .= "(?=;|\{)";
		$this->pattern .= "/mxs";
		
// 		$this->pattern = "/(\buse\b +?)(?<traitname>.*?)(?=;|\{)/ms";

		/* HACK: split multiple trait names separated by commas
		 */
		$matches = $this->matches($source);
		$result = [];
		foreach ($matches["traitname"] as $match){
			$arr = explode(",", $match );
			$result = array_merge( $result, $arr );
		}
		
		$this->matches["traitname"] = $result;
	}
	
	// HACK: overriding in case we had a single matches with commas
	function more_elements() : bool {
		return count( $this->matches[ "traitname" ] ) > $this->current_key;
	}
	
	function get_trait_name(): string {
		return trim( $this->matches["traitname"][$this->current_key] );
	}
	
}

?>