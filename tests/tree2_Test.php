<?php

use src\tree2;

class tree2_Test extends PHPUnit\Framework\TestCase {

	function test_1(){

		$source = "";
		$tree = new tree2();
		
		$this->assertEquals( false, $tree->more_elements());
	}
}