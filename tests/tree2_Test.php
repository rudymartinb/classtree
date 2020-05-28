<?php

use src\tree2;

class tree2_Test extends PHPUnit\Framework\TestCase {

	function test_empty(){
		$tree = new tree2();
		
		$this->assertEquals( false, $tree->more_elements());
	}
	
	function test_add_source(){
		
		$source = "";
		$tree = new tree2();
		
		$tree->add_source( $source );
		
		$this->assertEquals( true, $tree->more_elements());
	}
	
	
	
}