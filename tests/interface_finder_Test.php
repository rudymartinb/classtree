<?php

use src\interface_finder;

class interface_finder_Test extends PHPUnit\Framework\TestCase {
	
	function test_zero(){
		$source = '';
		
		$finder = new interface_finder( $source );
		
		$this->assertEquals( false, $finder->more_elements() );
	}
	
}

