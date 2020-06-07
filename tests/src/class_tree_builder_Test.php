<?php

class class_tree_builder_Test extends PHPUnit\Framework\TestCase {
	function test_basic(){
		$tree = new class_tree_builder_SPY();
		$this->assertEquals(0, $tree->get_num_classes() );
	}

	function test_size(){
		$source = 'class someclass {
}';
		
		$tree = new class_tree_builder_SPY();
		$tree->add_source( $source );

		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	
	function test_size_2(){
		$tree = new class_tree_builder_SPY();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	function test_size_3(){
		$tree = new class_tree_builder_SPY();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}

	
	function test_size_1_2(){
		$tree = new class_tree_builder_SPY();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		$tree->add_source( 'class someclass3 extends someclass {}' );
		
		$tree->resolve_class_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}

	
	function test_namespace(){
		$tree = new class_tree_builder_SPY();
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
		$tree = new class_tree_builder_SPY();
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

	
	function test_class_and_function(){
		$tree = new class_tree_builder_SPY();
		$tree->add_source( '
class someclass {}
	function fn1(){
	}
	function fn2( int $something, string $strong ){
	}
	function fn3() : string {
	}
}
' );
		
// 		$tree->resolve_class_hierarchy();
		
		$tree->select_class( "someclass" );
		$this->assertEquals( "fn1", $tree->get_function_name() );
		$this->assertEquals( "", $tree->get_function_return_type() );
		$tree->next_function();
		$this->assertEquals( "fn2", $tree->get_function_name() );
		$this->assertEquals( true, $tree->more_parameters() );
		$this->assertEquals( "int", $tree->get_function_parameter_type() );
		$this->assertEquals( "something", $tree->get_function_parameter_name() );
		$this->assertEquals( "", $tree->get_function_return_type() );
		$tree->next_function();
		$this->assertEquals( "fn3", $tree->get_function_name() );
		$this->assertEquals( "string", $tree->get_function_return_type() );
		
		
	}

	
	function test_class_and_usetrait(){
		$tree = new class_tree_builder_SPY();
		$tree->add_source( '
class someclass {}
	use trait1, trait2;
	function fn1(){
	}
	function fn2( int $something, string $strong ){
	}
	function fn3() : string {
	}
}
' );
		
		$tree->select_class( "someclass" );
		$this->assertEquals( true, $tree->more_usetraits() );
		$this->assertEquals( "trait1", $tree->get_usetrait_name() );
		$tree->next_usetrait();
		$this->assertEquals( true, $tree->more_usetraits() );
		$this->assertEquals( "trait2", $tree->get_usetrait_name() );
		
	}

	
	

}