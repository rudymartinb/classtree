<?php

use scr\node;

class node_Test extends PHPUnit\Framework\TestCase {
	
	function test_basic(){
		$tree = new node( "node" );
		$this->assertEquals( 0, $tree->get_width() );
	}
}

