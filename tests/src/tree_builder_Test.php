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
		$tree->add_source( 'namespace src;
class someclass2 extends someclass {}' );
		$tree->add_source( 'class someclass3 extends someclass {}' );
		
		$tree->resolve_class_hierarchy();
		
		$tree->select_class( "someclass" );
		$this->assertEquals( "src", $tree->get_namespace( "someclass" ) );
		$tree->select_class( "someclass2" );
		$this->assertEquals( "src", $tree->get_namespace( "someclass2" ) );
		$tree->select_class( "someclass3" );
		$this->assertEquals( "", $tree->get_namespace( "someclass3" ) );
	}

	
	function test_2_namespace(){
		$tree = new class_tree_builder();
		$tree->add_source( 'namespace src1 {
class someclass {}
}
namespace src2 {
class someclass2 extends someclass {
}' );
		
		$tree->resolve_class_hierarchy();
		
		$tree->select_class( "someclass" );
		$this->assertEquals( "src1", $tree->get_namespace() );
		$tree->select_class( "someclass2" );
		$this->assertEquals( "src2", $tree->get_namespace() );

	}

	
// 	function test_class_and_function(){
// 		$tree = new class_tree_builder();
// 		$tree->add_source( '
// class someclass {}
// 	function fn1(){
// 	}
// 	function fn2( int $something ){
// 	}
// 	function fn3() : string {
// 	}
// }
// ' );
		
// // 		$tree->resolve_class_hierarchy();
		
// 		$tree->select_class( "someclass" );
// // 		$this->assertEquals( "fn1", $tree->get_function_name() );

		
// 	}
	
	

}