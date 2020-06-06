<?php

use src\class_tree_builder;

class tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$tree = new class_tree_builder();
		$this->assertEquals(0, $tree->get_num_classes() );
	}

	function test_size(){
		$source = 'class someclass {
}';
		
		$tree = new class_tree_builder();
		$tree->add_source( $source );

		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	
	function test_size_2(){
		$tree = new class_tree_builder();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	function test_size_3(){
		$tree = new class_tree_builder();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}

	
	function test_size_1_2(){
		$tree = new class_tree_builder();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		$tree->add_source( 'class someclass3 extends someclass {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}

	
	function test_namespace(){
		$tree = new class_tree_builder();
		$tree->add_source( 'namespace src;
class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		$tree->add_source( 'class someclass3 extends someclass {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}
	
	

}