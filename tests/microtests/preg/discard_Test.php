<?php

class discard_Test extends PHPUnit\Framework\TestCase {
	private $pattern = '/".*"(?R)*/x';

	function test_do_not(){
		$source = '"do not"';
		
		$expected = '"do not"';
		$this->run_grep_test($source, $expected);
	}
	
	function test_basic(){
		$source = "discard \"me\" after this";
		
		$expected = '"me"';
		$this->run_grep_test($source, $expected);
	}

// 	function test_do_not_discard_me(){
// 		$source = "do not discard me!";
		
// 		$expected = 'do not !';
// 		$this->run_grep_test($source, $expected);
// 	}

	
	function run_grep_test( string $source, string $expected ){
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
}