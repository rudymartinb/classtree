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
		
		$pattern  = "/^";
		$pattern .= "(";
		$pattern .= "(?:[ ]*)";
		$pattern .= "(?<fnmod>(static|private|public|final|))";
		$pattern .= "(?:[ ]*)";
		$pattern .= "(?<fntag>function)";
		$pattern .= "(?:[ ]*)";
		$pattern .= "(?<name>[0-9a-zA-Z_]+)[ ]*\(";
		$pattern .= "(?:[ ]*)";
		$pattern .= "(?<params>[0-9a-zA-Z_\$ ,]*|)[ ]*\)";
		$pattern .= "((?:[ ]*\:[ ]*)(?<fnret>[0-9a-zA-Z_]*)[ ]*|)";
		$pattern .= ")";
		$pattern .= "/m";
		
		$this->pattern = $pattern;
		
		$this->matches($source);

	}
	
	private $params_finder;
	
	function next(){
		$this->current_key ++;
	}
	function get_name(): string {
		return $this->matches["name"][$this->current_key];
	}
	
	function has_parameters() : bool {
		$source = $this->matches["params"][$this->current_key];
		$this->params_finder = new parameters_finder($source);
		return $this->params_finder->more_elements();
	}
	

	function get_parameter_name() : string {
		return $this->params_finder->get_name();
	}
	
	function get_parameter_type() : string {
		return $this->params_finder->get_type();
	}

	function get_pm() : Array {
		return $this->params_finder;
	}
	
	
	
	
}