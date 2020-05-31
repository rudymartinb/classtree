<?php
namespace src;
class interface_finder {
	use finder;
	
	function __construct( string $source ){
		$this->pattern = '/';
		
		$this->pattern .= "(?:interface\s*)";
		$this->pattern .= "(?<ifname>[0-9a-zA-Z_]+)";
		
		// extends always goes before implements
		
		$this->pattern .= "(\s*extends\s*(?<extends>[0-9a-zA-Z_]*))*\s*";
		
		
		$this->pattern .= "(?<body>";
		$this->pattern .= "((?!(?R)).)*";
		$this->pattern .= ")";
		$this->pattern .= '/ms';
		
		$this->matches($source);
	}
	
	function get_name() : string {
		return $this->matches["ifname"][$this->current_key];
	}

	function get_extends() : string {
		return $this->matches["extends"][$this->current_key];
	}

	function get_body() : string {
		return $this->matches["body"][$this->current_key];
	}
	
	/*
	 * functions section:
	 * it should create a private function finder object
	 * apply it to the body source

	 */
	private $function_finder;
	function has_functions() : bool {
		$body = $this->get_body();
		
		$this->function_finder = new function_finder($body);
		
		return $this->function_finder->more_elements();
	}
	
}