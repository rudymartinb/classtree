<?php
namespace src;
class function_finder {
	use finder;
	
	function __construct( string $source ){
		$this->source = $source;
		
		$this->pattern  = "/^";
		$this->pattern .= "(\s*function\s+)";
		$this->pattern .= "(?<name>[a-zA-Z0-9_]*)";
		$this->pattern .= "\(";
		$this->pattern .= "\s*(?<params>[a-zA-Z0-0_\$, ]*\s*.)*";
		// 		$this->pattern .= "\s*(?<parname>\$[a-zA-Z0-0_]*\s*.),*)*";
		$this->pattern .= "\)\s*";
		
		/* for the namespace keyword
		 * then add all the code up to the next keyword.
		 *
		 * TODO: test this against a windows newline character file
		 * TODO: add function body ?
		 */
		
		$pattern  = '/';
		$pattern .= '(';
		$pattern .= '\s*';
		$pattern .= '(?<fnmod>(static|private|public|final|))';
		$pattern .= '\s*';
		$pattern .= '(?<fntag>function)';
		$pattern .= '\s*';
		$pattern .= '(?<name>[0-9a-zA-Z_]+)[ ]*\(';
		$pattern .= '\s*';
		$pattern .= '(?<params>[0-9a-zA-Z_\$\& ,]*|)[ ]*\)';
		$pattern .= '((?:\s*\:\s*)(?<fnret>[0-9a-zA-Z_]*)\s*|)';
		$pattern .= '[^\{;]*)';
		$pattern .= '/ms';
		
		$this->pattern = $pattern;
		
		$this->matches($source);

	}

	
	function get_name(): string {
		return $this->matches["name"][$this->current_key];
	}
	function get_return_type(): string {
		return $this->matches["fnret"][$this->current_key];
	}
	
	/* parameters section
	 */
	private $params_finder;
	function more_parameters() : bool {
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
	function next_parameter() {
		return $this->params_finder->next();
	}
	
	
}