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
		$pattern .= "/ms";
		
		$this->pattern = $pattern;
		
		$this->matches($source);

	}

	
	function get_name(): string {
		return $this->matches["name"][$this->current_key];
	}
	
	/* parameters section
	 */
	private $params_finder;
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
	
}