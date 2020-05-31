<?php


use src\usetrait_finder;

class usetrait_finder_Test extends PHPUnit\Framework\TestCase {
	function test_empty(){
		$finder = new usetrait_finder("");
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_somethingelse(){
		$finder = new usetrait_finder("asdfasdf");
		$this->assertEquals( false, $finder->more_elements() );
	}
	
}

