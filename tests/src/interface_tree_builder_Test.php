<?php


class interface_tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$builder = new interface_tree_builder_SPY();
		$collector = $builder->get_collector();
		$this->assertEquals(0, $collector->count() );
	}

	
	function test_size(){
		$source = 'interface someinterface {
}';
		
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( $source );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}
	
	
	function test_size_2(){
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( 'interface someinterface {}' );
		$tree->add_source( 'interface someinterface2 {}' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}
	
	function test_size_3(){
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( 'interface someinterface {}' );
		$tree->add_source( 'interface someinterface2 extends someinterface {} ' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}
	
	
	
}

