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
// 	var_dump( $finder->matches($source)["body"] );
// 	echo( "-----------------------------" );

	
	$this->assertEquals( 2, count( $finder->matches($source)[0] ) );
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
}';

	$body = $finder->get_body();
	$this->assertEquals( $expected, $body );
	
	$finder->next();
	$this->assertEquals( false, $finder->more_elements() );
}





function test_2_namespaces_with_body_2(){
	$source = 'namespace test{
	function test() {
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



	/*
	 * having a source code with 2 name spaces 
	 * should be considered a bad practice
	 */
// 	function test_just_2_line(){
// 		$source = '
// namespace test1;
// namespace test2;';
		
// 		$finder = new namespace_finder();
		
// 		$matches = $finder->matches( $source );
// 		$this->assertEquals( true, $finder->found() );
// 		$namespaces = $finder->split();
		
// 		$expected = [];
// 		$expected[] = [ "namespace" => "test1", "body"=>'\n' ];
// 		$expected[] = [ "namespace" => "test2", "body"=>'' ];
// 		$this->assertEquals( $expected, $namespaces );
// 	}
	
	
	
	
// 	function test1(){
		
// 		$source = '
// <?php
// namespace something;

// function body() {
// 	$head=1;
// }
// ';
		
// 		$finder = new namespace_finder();
		
// 		$matches = $finder->matches( $source );
// 		$bodies = $finder->find_bodies();
// 		$namespaces = $finder->split();
		
// 		//  var_dump($matches);
		
// 		$class = $classes[0]; // sarasa interface
		
// 		$expected = '
//     function algo() : string;
//     function algo1( string $something ) : string;
//     function algo2( father $father ) : string;
// }
// ';
// 		$this->assertEquals( $expected, $bodies["sarasa_interface"] );
// 		$this->assertEquals( "sarasa_interface", $class->get_name() );
// 		$this->assertEquals( $expected, $class->get_body() );
		
// 	}
    
}

