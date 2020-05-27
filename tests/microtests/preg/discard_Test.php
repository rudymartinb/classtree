<?php

class discard_Test extends PHPUnit\Framework\TestCase {
	private $pattern = "/discard me/x";
	
	function run_grep_test( string $source, string $expected ){
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
	function test_preg_just_2_braces(){
		$source = "discard me";
		
		$expected = '';
		$this->run_grep_test($source, $expected);
	}
	
}