<?php

use src\tree_builder;

class tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_nothing(){
		$tree = new tree_builder();
		$this->assertEquals(0, $tree->get_num_classes() );
	}
	

}