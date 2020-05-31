<?php
namespace src;
class interface_finder {
	use finder;
	
	function __construct( string $source ){
		$this->pattern = '/';
		
		$this->pattern .= "(?:interface\s*)";
		$this->pattern .= "(?<ifname>[0-9a-zA-Z_]+)";
		
		// extends always goes before implements
		
		$this->pattern .= "(\s*extends\s*(?<extends>[0-9a-zA-Z_]*))*";
		
		
		$this->pattern .= "(?<body>";
		$this->pattern .= "((?!(?R)).)*";
		$this->pattern .= ")";
		$this->pattern .= '/ms';
		
		$this->matches($source);
		
	}
	
}