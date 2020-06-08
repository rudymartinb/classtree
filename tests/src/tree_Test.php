<?php

use tree\tree;

class tree_Test extends PHPUnit\Framework\TestCase {
	
	function test_basic(){
		$tree = new tree( [] );
		$this->assertEquals( 0, $tree->get_width() );
		
	}
}

