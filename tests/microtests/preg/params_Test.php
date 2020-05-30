<?php

class params_Test extends PHPUnit\Framework\TestCase {
	
	private $pattern;
	function setUp() : void {
// 		$this->pattern  = '/(((?<partype>[a-zA-Z0-9_]*) )\s*(\$*(?<parname>[a-zA-Z0-9_]*)\s*)\s*,\s*)*/ms';
		
// 		$this->pattern  = '/(((?:(?<partype>[a-zA-Z0-9_]*)\s{1})*(\$*(?<parname>[a-zA-Z0-9_]*)\s*)\s*[,]{0,1}\s*)*)*/mxs';
		
		$this->pattern  = '/(?<partype>[a-zA-Z0-9_]*)\s*';
		$this->pattern .= '\$(?<parname>[a-zA-Z0-9_]*)/mxs';
// 		$this->pattern  = '/(?<parname>[a-zA-Z0-9_]*)*/mxs';
	}
	
	function test_nothing(){
		$source = '';
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$this->assertTrue( count( $matches ) > 0);
	}

	
	function test_just_name(){
		$source = '$sarasa';
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		
		$this->assertEquals( "sarasa", $matches["parname"][0] );
	}

	
	function test_type_and_name(){
		$source = 'int $sarasa';
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		
		var_dump($matches[0]);
		var_dump($matches["partype"]);
		
		$this->assertEquals( "int", $matches["partype"][0] );
		$this->assertEquals( "sarasa", $matches["parname"][0] );
	}

// 	function test_2_params(){
// 		$source = 'int $sarasa, string $acanomas';
		
// 		$matches = [];
// 		preg_match_all($this->pattern, $source, $matches );
// 		var_dump($matches["partype"]);
// 		var_dump($matches["parname"]);
		
// 		$this->assertEquals( "int", $matches["partype"][0] );
// 		$this->assertEquals( "sarasa", $matches["parname"][0] );
// 		$this->assertEquals( "string", $matches["partype"][1] );
// 		$this->assertEquals( "acanomas", $matches["parname"][1] );
		
// 	}
	
	
}

