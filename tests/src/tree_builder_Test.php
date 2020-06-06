<?php

use src\tree_builder;

class tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$tree = new tree_builder();
		$this->assertEquals(0, $tree->get_num_classes() );
	}

	function test_search_class(){
		$source = 'class someclass {
}';
		
		$tree = new tree_builder();
		$tree->add_source( $source );
		$this->assertEquals( 0, $tree->search_class("someclass") );
		$this->assertEquals( -1, $tree->search_class("does_not_exist") );
	}

	function test_namespace(){
		$source = 'namespace src;
class someclass {
}';
		
		$tree = new tree_builder();
		$tree->add_source( $source );
		$this->assertEquals( 0, $tree->search_class("someclass") );
		$this->assertEquals( -1, $tree->search_class("does_not_exist") );
	}
	
	

}