<?php

use src\namespace_finder;

/*
 * there's little point in wasting a class just to hold a character string 
 * if there's not much use we can make of it.
 * 
 * so the plan is to make that class hold the body as well 
 * which would be the entire source code if the namespace just end with ";"
 */
class namespace_finder_Test extends PHPUnit\Framework\TestCase {
	function test_empty(){
		$source = '';
		
		$finder = new namespace_finder( $source );

		$this->assertEquals( false, $finder->more_elements() );
	}
	
	function test_something_else(){
		$source = 'this is a test';
		
		$finder = new namespace_finder( $source );
		
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_just_1_line(){
		$source = 'namespace test;';
		
		$finder = new namespace_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		$finder->next();
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_just_1_namespace_with_body_1(){
		$source = 'namespace test;
function test() {
}
';
	
	$finder = new namespace_finder( $source );
	
	$this->assertEquals( true, $finder->more_elements() );
	$this->assertEquals( "test", $finder->get_name() );

	/*  newline is not counted as preg match
	 */
	$expected = '
function test() {
}
';
// 	$body = $finder->get_body();
	$this->assertEquals( $expected, $finder->get_body() );
	$finder->next();
	$this->assertEquals( false, $finder->more_elements() );
}

	
	
	function test_2_namespaces_with_body(){
	
		$source = 'namespace test;
function test() {
}

namespace test2;
function test2() {
}';
	
		$finder = new namespace_finder( $source );
		
	// 	var_dump( $finder->matches($source)["original"] );
	// 	echo( "-----------------------------" );
	// 	var_dump( $finder->matches($source)["0"] );
	// 	echo( "-----------------------------" );
	// 	var_dump( $finder->matches($source)["body"] );
	// 	echo( "-----------------------------" );
		
		$this->assertEquals( 2, count( $finder->matches($source)[0] ) );
	
		
		$expected = '
function test() {
}

';
		$this->assertEquals( $expected, $finder->get_body() );
		
		$finder->next();
	
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test2", $finder->get_name() );
	
		$expected = '
function test2() {
}';

		$body = $finder->get_body();
		$this->assertEquals( $expected, $body );
		
		$finder->next();
		$this->assertEquals( false, $finder->more_elements() );
	}
	

	function test_3_namespaces_with_body(){
		$source = 'namespace test;
function test() {
}
			
namespace test2;
function test2() {
}
namespace test3;
function test3() {
}
';
		
		$finder = new namespace_finder( $source );
		
		// 	var_dump( $finder->matches($source)["original"] );
		// 	echo( "-----------------------------" );
	// 		var_dump( $finder->matches($source)["0"] );
		// 	echo( "-----------------------------" );
		// 	var_dump( $finder->matches($source)["body"] );
		
		$this->assertEquals( 3, count( $finder->matches($source)[0] ) );
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
	
	
	$expected = '
function test() {
}
			
';
		
		$this->assertEquals( $expected, $finder->get_body() );
		
		$finder->next();
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test2", $finder->get_name() );
		
		$expected = '
function test2() {
}
';
	
		$body = $finder->get_body();
		$this->assertEquals( $expected, $body );
		
		$finder->next();
		$this->assertEquals( true, $finder->more_elements() );
		
		// todo: the rest ?
	}
	
	
	
	
	
	function test_2_namespaces_with_body_2(){
		$source = "namespace test{\n";
		$source .= 'function test() {
	}
}
namespace test2{

	function test2() {
	}
}
';
	
		$finder = new namespace_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		
		
		$expected = '
function test() {
	}
}
';
		$body = $finder->get_body();
		$this->assertEquals( $expected, $finder->get_body() );
		$finder->next();
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test2", $finder->get_name() );
		
		$expected = '

	function test2() {
	}
}
';
	
	$body = $finder->get_body();
	$this->assertEquals( $expected, $body );
	
	$finder->next();
	$this->assertEquals( false, $finder->more_elements() );
}

    
}

