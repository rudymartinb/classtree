<?php

use src\trait_finder;

class trait_finder_Test extends PHPUnit\Framework\TestCase {
	function test_nothing(){
		$source = "";
		$finder = new trait_finder($source);
		
		$this->assertFalse( $finder->more_elements() );
		
	}
	
}