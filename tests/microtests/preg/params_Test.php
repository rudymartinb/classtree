<?php

class params_Test extends PHPUnit\Framework\TestCase {
	
	private $pattern;
	function setUp(){
		$this->pattern  = "/^";
// 		$this->pattern .= "((?<partype>[a-zA-Z0-9_]*) )\s*";
// 		$this->pattern .= "(\$(?<parname>[a-zA-Z0-9_]*))\s*";
// 		$this->pattern .= ",.)*";
		$this->pattern .= "/mxs";
		
	}
	
	function test_params_0(){
		$source = 'int $uno, string $dos';
		
		
		$matches = [];
		preg_match_all($pattern, $source, $matches );
		var_dump($matches[0]);
		
	}
	
	
}

