<?php

class params_Test extends PHPUnit\Framework\TestCase {
	
	private $pattern;
	function setUp() : void {
		$this->pattern  = "/^";
// 		$this->pattern .= "((?<partype>[a-zA-Z0-9_]*) )\s*";
// 		$this->pattern .= "(\$(?<parname>[a-zA-Z0-9_]*))\s*";
// 		$this->pattern .= ",.)*";
		$this->pattern .= "/mxs";
		
	}
	
	function test_nothing(){
		$source = '';
		
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
// 		var_dump($matches[0]);
		
		$this->assertTrue( count( $matches ) > 0);
	}

	
	function test_just_name(){
		$source = '$sarasa';
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		var_dump($matches[0]);
		
		$this->assertTrue( count( $matches ) > 0);
	}
	
	
}

