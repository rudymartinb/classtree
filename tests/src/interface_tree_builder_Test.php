<?php

use src\interface_tree_builder;

class interface_tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$builder = new interface_tree_builder_SPY();
		$collector = $builder->get_collector();
		$this->assertEquals(0, $collector->count() );
	}
	
}

