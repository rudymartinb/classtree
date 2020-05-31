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
	
}

