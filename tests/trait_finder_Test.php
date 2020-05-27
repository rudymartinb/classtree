<?php

use src\trait_finder;

class trait_finder_Test extends PHPUnit\Framework\TestCase {
	function test_nothing(){
		$source = "";
		$finder = new trait_finder($source);
		
		$this->assertFalse( $finder->more_elements() );
		
	}

	function test_name(){
		$source = "trait test {}";
		$finder = new trait_finder($source);
		
		$this->assertTrue( $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		
	}
	
}