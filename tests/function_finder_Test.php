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
		$this->assertEquals(false, $finder->more_elements() );
	}

	function test_simple_function(){
		$source = "function simple() {}";
		
		$finder = new function_finder( $source );

		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "simple", $finder->get_name() );

		$this->assertEquals( false, $finder->has_parameters() );
	}

	
	function test_next(){
		$source = "function simple() {
}
function complex(){
}";
		
		$finder = new function_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "simple", $finder->get_name() );
		
		$this->assertEquals( false, $finder->has_parameters() );
		
		$finder->next();
		$this->assertEquals( "complex", $finder->get_name() );
	}
	
	
	function test_function_1_parameter(){
		$source = 'function simple( int $something ) {}';
		
		$finder = new function_finder( $source );
		
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "simple", $finder->get_name() );
		
		
		$this->assertEquals( true, $finder->has_parameters() );
		
		$this->assertEquals( "int", $finder->get_parameter_type() );
		$this->assertEquals( "something", $finder->get_parameter_name() );
		
	}

	
	function test_2_params(){
		$source = 'function simple() {
}
function complex( int $ant, string& $strong ){
}';
		
		$finder = new function_finder( $source );
		
		$matches = $finder->matches($source);
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "simple", $finder->get_name() );
		
		$this->assertEquals( false, $finder->has_parameters() );
		
		$finder->next();
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "complex", $finder->get_name() );
		
		$this->assertEquals( true, $finder->has_parameters() );

		$this->assertEquals( "int", $finder->get_parameter_type() );
		$this->assertEquals( "ant", $finder->get_parameter_name() );
		$finder->next_parameter();
		$this->assertEquals( "string", $finder->get_parameter_type() );
		$this->assertEquals( "strong", $finder->get_parameter_name() );
		
		
		
	}
	
	
	
}