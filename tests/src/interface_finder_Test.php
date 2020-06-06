<?php

use src\interface_finder;

class interface_finder_Test extends PHPUnit\Framework\TestCase {
	
	function test_zero(){
		$source = '';
		
		$finder = new interface_finder( $source );
		
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_nada(){
		$source = 'nada';
		
		$finder = new interface_finder( $source );
		
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_basic(){
		$source = 'interface myif {}';
		
		$finder = new interface_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "myif", $finder->get_name() );
	}
	
	function test_extends(){
		$source = 'interface myif extends mysuper {}';
		
		$finder = new interface_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "myif", $finder->get_name() );
		$this->assertEquals( "mysuper", $finder->get_extends() );
	}

	function test_body(){
		$body = '{
function something1();
function something2();
}';
		$source = 'interface myif '.$body;
		
		$finder = new interface_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "myif", $finder->get_name() );
		$this->assertEquals( $body, $finder->get_body() );
	}

	function test_functions(){
		$body = '{
function something1();
function something2( int $ant, string $strong );
}';
		$source = 'interface myif '.$body;
		
		$finder = new interface_finder( $source );
		
		// function something1
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "myif", $finder->get_name() );
		$this->assertEquals( true, $finder->more_functions() );
		$this->assertEquals( "something1", $finder->get_function_name() );
		$this->assertEquals( false, $finder->more_parameters() );
		$finder->next_function();
		$this->assertEquals( "something2", $finder->get_function_name() );
		$finder->next_parameter();
		$this->assertEquals( true, $finder->more_parameters() );
		$this->assertEquals( "int", $finder->get_parameter_type() );
		$this->assertEquals( "ant", $finder->get_parameter_name() );
		
		
		
	}
	
	
}

