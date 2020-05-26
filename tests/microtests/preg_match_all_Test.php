<?php


class preg_match_all_Test extends PHPUnit\Framework\TestCase {
	
	function test_preg(){
		$source =" mario 1 2 3 bros 2 3 1 ";
		/*
		 * I dont really know what can be less confusing
		 * if having everything on one line or multiple lines./
		 */
		$pattern = "/";
		$pattern .= "\s*";
		$pattern .= "(";
		$pattern .= "\s*";
		$pattern .= "(?<mario>mario([\s\,]*[0-9])*)";
		$pattern .= "\s*";
		$pattern .= "|";
		$pattern .= "\s*";
		$pattern .= "(?<bros>bros([\s\,]*[0-9])*)";
		$pattern .= "\s*";
		$pattern .= ")*";
		$pattern .= "/ms";
		
		$matches = [];
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario 1 2 3", $matches["mario"][0] );
		$this->assertEquals( "bros 2 3 1", $matches["bros"][0] );
		
		$source =" bros 2 3 1 mario 1 2 3";
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario 1 2 3", $matches["mario"][0] );
		$this->assertEquals( "bros 2 3 1", $matches["bros"][0] );
		
		$source =" bros 2,3,1 mario 1 2 3";
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario 1 2 3", $matches["mario"][0] );
		$this->assertEquals( "bros 2,3,1", $matches["bros"][0] );
		
		$source =" bros 2, 3, 1 mario 1 2 3";
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario 1 2 3", $matches["mario"][0] );
		$this->assertEquals( "bros 2, 3, 1", $matches["bros"][0] );
		
		
	}
	
}

