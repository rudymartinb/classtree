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
		$this->pattern .= "\s*(?<params>[a-zA-Z0-0_\$, ]*\s*.)*";
// 		$this->pattern .= "\s*(?<parname>\$[a-zA-Z0-0_]*\s*.),*)*";
		$this->pattern .= "\)\s*";
		
		
		$this->pattern .= "/mxs";
		
		$this->matches($source);
	}
	
	function next(){
		$this->current_key ++;
		$this->current_param = 0;
	}
	function get_name(): string {
		return $this->matches["name"][$this->current_key];
	}
	private $current_param = 0;
	function has_parameters() : bool {
		return $this->matches["params"][$this->current_key] != "";
	}

	private $params_matches = [];
	function get_parameters(){
		$params = $this->matches["params"][$this->current_key];
		
		$pattern  = "/^(";
		$pattern .= "((?<partype>[a-zA-Z0-9_]*) )\s*";
		$pattern .= "(\$(?<parname>[a-zA-Z0-9_]*))\s*";
		$pattern .= ",.)*";

		$pattern .= "/mxs";
		
		$matches = [];
		preg_match_all($pattern, $params, $matches );
		$this->params_matches = $matches;
	}
	function get_pm() : Array {
		return $this->params_matches;
	}
	
	
	
	
}