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
		
		$this->assertEquals( 1, $tree->get_max_columns() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}
	
	
	function test_size_2(){
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( 'interface someinterface {}' );
		$tree->add_source( 'interface someinterface2 {}' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_columns() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}
	
	function test_size_3(){
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( 'interface someinterface {}' );
		$tree->add_source( 'interface someinterface2 extends someinterface {} ' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_columns() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}
	
	
	function test_2_namespace(){
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( 'namespace src1; 
interface someinterface {}' );
		$tree->add_source( 'namespace src2;
interface someinterface2 ' );
		
		$tree->resolve_hierarchy();
		
		$collector = $tree->get_collector();
		
		$collector->select( "someinterface" );
		$this->assertEquals( "src1", $collector->get_namespace() );
		$collector->select( "someinterface2" );
		$this->assertEquals( "src2", $collector->get_namespace() );

		$this->assertEquals( 2, $tree->get_max_columns() );
		$this->assertEquals( 1, $tree->get_max_height() );
		
		$tree->draw("/tmp/if.png");
	}
	
	
	function test_class_and_function(){
		$tree = new interface_tree_builder_SPY();
		$tree->add_source( '
interface someinterface {
	function fn1(){
	}
	static function fn2( int $something, string $strong ){
	}
	abstract static function fn3() : string {
	}
}
' );
		
		// 		$tree->resolve_class_hierarchy();
		
		$collector = $tree->get_collector();
		
		$collector->select( "someinterface" );
		
		$collector->next_function();
		$this->assertEquals( "static", $collector->get_function_static() );
		
		// functions parameters and return values
		$collector->select( "someinterface" );
		$this->assertEquals( "fn1", $collector->get_function_name() );
		$this->assertEquals( "", $collector->get_function_return_type() );
		$collector->next_function();
		$this->assertEquals( "fn2", $collector->get_function_name() );
		$this->assertEquals( true, $collector->more_parameters() );
		$this->assertEquals( "int", $collector->get_function_parameter_type() );
		$this->assertEquals( "something", $collector->get_function_parameter_name() );
		$this->assertEquals( "", $collector->get_function_return_type() );
		$collector->next_function();
		$this->assertEquals( "fn3", $collector->get_function_name() );
		$this->assertEquals( "string", $collector->get_function_return_type() );
		
		
		
	}
	
	
	
}

