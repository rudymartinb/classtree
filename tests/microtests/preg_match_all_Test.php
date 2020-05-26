<?php


class preg_match_all_Test extends PHPUnit\Framework\TestCase {
	
	function test_preg(){
		$source =" mario a b c bros 2 3 1 ";
		/*
		 * I dont really know what can be less confusing
		 * if having everything on one line or multiple lines./
		 */
		$pattern = "/";
		$pattern .= "\s*";
		$pattern .= "(";
		$pattern .= "\s*";
		$pattern .= "(?<mario>mario";
		$pattern .= "((?! bros)(?:[\s\,]+[0-9a-z]+))*";
		$pattern .= ")*";
		$pattern .= "\s*";
		$pattern .= "|";
// 		$pattern .= "\s*";
		$pattern .= "(?<bros>bros";
		$pattern .= "((?! mario)(?:[\s\,]+[0-9a-z]+))*";
		$pattern .= ")*";
		$pattern .= "\s*";
		$pattern .= ")*";
		$pattern .= "/ms";
		
		$matches = [];
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario a b c", $matches["mario"][0] );
		
		$this->assertEquals( "bros 2 3 1", $matches["bros"][2] );
		
		$source =" bros 2 3 1 mario 1 2 3";
		preg_match_all($pattern, $source, $matches );
// 		var_dump($matches["mario"]);
		$this->assertEquals( "mario 1 2 3", $matches["mario"][2] );
		$this->assertEquals( "bros 2 3 1", $matches["bros"][2] );
		
		$source =" bros 2,3,1 mario 1 2 3";
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario 1 2 3", $matches["mario"][2] );
		$this->assertEquals( "bros 2,3,1", $matches["bros"][2] );
		
		$source =" bros 2, 3, 1 mario 1 2 3";
		preg_match_all($pattern, $source, $matches );
		$this->assertEquals( "mario 1 2 3", $matches["mario"][2] );
		$this->assertEquals( "bros 2, 3, 1", $matches["bros"][2] );
		
		
	}
	
}

