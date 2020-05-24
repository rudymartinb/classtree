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
	function test_no_namespace(){
		
		$source = '';
		
		$finder = new namespace_finder();
		
		$matches = $finder->matches( $source );
		$this->assertEquals( [], $matches[0] );
		
		$bodies = $finder->find_bodies();
		$this->assertEquals( [], $bodies );
		
		$namespaces = $finder->split();
		$this->assertEquals( [], $namespaces );
		
	}
	
	
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

