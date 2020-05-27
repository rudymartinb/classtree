<?php


class preg_match_all_Test extends PHPUnit\Framework\TestCase {
	/*
	 * this test is intended
	 * to gather all the body of a class or function or anything
	 */
	private $pattern = "/
\{
(
((?R)*)
|
([^{}]*)*
)*
\}
/x";
	
	// ok  private $pattern = "/({(.*)})|({(?R)})/";
	
	# "/[^{}]*\{(?R)\}/mx";
	function run_grep_test( string $source, string $expected ){
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	function test_preg_just_2_braces(){
		$source = "{}";
		
		$expected = '{}';
		$this->run_grep_test($source, $expected);
	}
	
	function test_preg_just_3_braces(){
		$source = "{}}";
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
	function test_preg_just_2_braces_with_something(){
		$source = "{a}}{}";

		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{a}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}

	function test_preg_just_2_braces_with_something_2(){
		$source = "a{a}a{a}a";
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{a}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
	function test_preg_more_braces(){
		$source = "{a{a}}";

		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{a{a}}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
	function test_preg_a_lote_more_braces(){
		$source = "{{{{{{{a}}}}}}}";

		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{{{{{{{a}}}}}}}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}

	function test_with_junk(){
		$source = " asdf {a{a{a{a{a{{a}}a}a}a}a}} asdf";

		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{a{a{a{a{a{{a}}a}a}a}a}}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}


	// 	function test_preg_recursive(){
	
	
	// 		$pattern  = '/';
	
	// 		$pattern .= '(?:';
	// 		$pattern .= '(';
	// // 		$pattern .= '(?![^{}]*)|';
	// // 		$pattern .= '(?:(?C!"[^"]*").)|';
	// 		$pattern .= '(\{(?R)\})*';
	// 		$pattern .= ')*';
	// 		$pattern .= ')*';
	// 		$pattern .= '/mx';
	
	// // 		$pattern = '/(([^{}]*)|\{(?R)\})*/mx';
	
	// // 		$source = ' {{{}{}}} ';
	
	// 		$matches = [];
	// // 		$source = '{{{"}"d}d{d}}} outside}';
	// 		$source = '{{{d}d{d}}} outside}';
	
	// 		preg_match_all($pattern, $source, $matches );
	// 		$expected = '{{{d}d{d}}}';
	// 		$actual = $matches[0][0];
	// 		$this->assertEquals($expected, $actual);
	
	
	// // 		var_dump($matches);
	
	// // 		$source = 'discard {{{d}d{d}}} outside}';
	// // 		preg_match_all($pattern, $source, $matches );
	// // 		$expected = '{{{}{}}}';
	// // 		$actual = $matches[0][0];
	// // 		$this->assertEquals($expected, $actual);
	
	// 		// 		$source = 'discard {{{d}d{d}}} outside}';
	
	// 		// 		preg_match_all($pattern, $source, $matches );
	// 		// 		$expected = '{{{d}d{d}}}';
	// 		// 		$actual = $matches[0][0];
	// 		// 		$this->assertEquals($expected, $actual);
	
	
	
	
	// 	}
	
	
	//
	
	function test_preg(){
		$source =" mario a b c bros 2 3 1 ";
		/*
		 * I dont really know what can be less confusing
		 * if having everything on one line or multiple lines./
		 */
		$pattern = "/";
		$pattern .= "\s*";
		$pattern .= "(";
// 		$pattern .= "\s*";
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

