<?php

use function files\get_all_files;
use function files\get_source;
use function files\get_sources;
use function files\get_php_files;
use function files\get_clases;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;
use function files\get_interfaces;
use src\class_finder;

class filesTest extends PHPUnit\Framework\TestCase {

// 	function test_discard(){
// 		$source = 'this is a "discard" test';
		
// 		$pattern  = '/(?<ori>(?!"discard").|(?R))*';
// 		$pattern .= '/m';
		
// 		$matches = [];
	
// 		preg_match_all($pattern, $source, $matches );
// 		$expected = 'this is a test';
// 		$actual = $matches["ori"][0];
// 		var_dump( $actual );
// 		$this->assertEquals($expected, $actual);
		
// 	}
	
	/*
	 * this test is intended 
	 * to gather all the body of a class or function or anything
	 */
	private $pattern = "/\{([^{}]*|(?R))\}/mx";
	
	function test_preg_just_2_braces(){
		$source = "{}";
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
	function test_preg_just_2_braces_with_something(){
		$source = "{a}";
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{a}';
		$actual = $matches[0][0];
		$this->assertEquals($expected, $actual);
	}
	
	function test_preg_more_braces(){
		$source = "{{a}}";
		
		$matches = [];
		preg_match_all($this->pattern, $source, $matches );
		$expected = '{{a}}';
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

// 	function test_with_junk(){
// 		$source = " asdf {a{a{a{a{a{{a}}a}a}a}a}} asdf";
		
// 		$matches = [];
// 		preg_match_all($this->pattern, $source, $matches );
// 		$expected = '{a{a{a{a{a{{a}}a}a}a}a}}';
// 		$actual = $matches[0][0];
// 		$this->assertEquals($expected, $actual);
// 	}
	
	
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
    
    
    /* this test uses fixed files on tests/dummy dir
     * adding or removing files will cause this test to fail
     *
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */

    function test_get_files_FAIL_1() {
        $path = "/asdfasdf";
        $source = get_all_files( $path );
        $this->assertEquals( 0, count( $source ) );
    }
    function test_get_files_FAIL_2() {
        $path = "/bin/bash";
        $source = get_all_files( $path );
        $this->assertEquals( 0, count( $source ) );
    }
    
    
    function test_get_files() {
        $path = "./tests/dummy";
        $source = get_all_files( $path );
        $this->assertEquals( 3, count( $source ) );
    }


    function test_separate_php_fail(){
        $phpfiles = get_php_files( [] );
        $this->assertEquals( 0, count( $phpfiles ) );
    }

    function test_separate_php_fail_2(){
        $phpfiles = get_php_files( [ null ] );
        $this->assertEquals( 0, count( $phpfiles ) );
    }
    
    function test_separate_php(){
        $path = "./tests/dummy";
        $source = get_all_files( $path );
        $phpfiles = get_php_files( $source );
        $this->assertEquals( 3, count( $phpfiles ) );
    }
    
    function test_get_source_from_file() {
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        $this->assertTrue( $source != ""  );
    }
    
    function test_get_sources() {
        $path = "./tests/dummy";
        $files = get_all_files( $path );
        $sources = get_sources( $files );
        $this->assertEquals( 3, count( $sources ) );
    }

    
    
    
    function test_array_search() {
        $searchfor = "sarasa";
        $arr = [];
        $arr[] = "a";
        $arr[] = "sara";
        $arr[] = "asara";
        $arr[] = "asarasa";
        $arr[] = "sarasa";
        
        $this->assertEquals( 4, array_search($searchfor, $arr));
    }
    
    

}
