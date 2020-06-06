<?php

use src\tree_builder;

class tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$tree = new tree_builder();
		$this->assertEquals(0, $tree->get_num_classes() );
	}

	function test_size(){
		$source = 'class someclass {
}';
		
		$tree = new tree_builder();
		$tree->add_source( $source );

		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	
	function test_size_2(){
		$tree = new tree_builder();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 {}' );
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}
	
	

}