<?php

use src\function_finder;

/* same as traits
 * based on the body of a class
 * look for functions tags
 * and then split arguments and return value
 * 
 */
class function_finder_Test extends PHPUnit\Framework\TestCase {
	function test_nothing(){
		$source = "";
		$finder = new function_finder( $source );
		var_dump( $finder->matches($source) );
		$this->assertEquals(false, $finder->more_elements() );
	}
	
}