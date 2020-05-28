<?php

class discard_Test extends PHPUnit\Framework\TestCase {
	private $pattern = '/^("[^"]*")$/mx';

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
	
	function test_basic_2(){
		$source = 'discard "me" after this "me" "me" ' ;
		
		$expected = '"me""me""me"';
		$this->run_grep_test($source, $expected);
	}

	
	function run_grep_test( string $source, string $expected ){
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
}