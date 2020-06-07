<?php
use src\class_collector;
use src\tree_builder;

class class_tree_builder_Test extends PHPUnit\Framework\TestCase {
	function create() : tree_builder {
		return new class_tree_builder_SPY();
	}
	function mysetup() : class_tree_builder_SPY {
		return $this->create();
	}
	
	function test_basic(){
		$tree = $this->mysetup();
		$this->assertEquals(0, $tree->get_num_classes() );
	}

	function test_size(){
		$source = 'class someclass {
}';
		
		$tree = $this->mysetup();
		$tree->add_source( $source );

		$tree->resolve_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	
	function test_size_2(){
		$tree = $this->mysetup();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 {}' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 1, $tree->get_max_height() );
	}

	function test_size_3(){
		$tree = $this->mysetup();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 1, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}

	
	function test_size_1_2(){
		$tree = $this->mysetup();
		$tree->add_source( 'class someclass {}' );
		$tree->add_source( 'class someclass2 extends someclass {}' );
		$tree->add_source( 'class someclass3 extends someclass {}' );
		
		$tree->resolve_hierarchy();
		
		$this->assertEquals( 2, $tree->get_max_width() );
		$this->assertEquals( 2, $tree->get_max_height() );
	}

	
	function test_namespace(){
		$tree = $this->mysetup();
		$tree->add_source( 'namespace src;
class someclass {}' );
		$tree->add_source( 'namespace src;
class someclass2 extends someclass {}' );
		$tree->add_source( 'class someclass3 extends someclass {}' );
		
		$tree->resolve_hierarchy();
		
		$collector = $tree->get_collector();
		
		$collector->select( "someclass" );
		$this->assertEquals( "src", $collector->get_namespace( "someclass" ) );
		$collector->select( "someclass2" );
		$this->assertEquals( "src", $collector->get_namespace( "someclass2" ) );
		$collector->select( "someclass3" );
		$this->assertEquals( "", $collector->get_namespace( "someclass3" ) );
	}

	
	function test_2_namespace(){
		$tree = $this->mysetup();
		$tree->add_source( 'namespace src1 {
class someclass {}
}
namespace src2 {
class someclass2 extends someclass {
}' );
		
		$tree->resolve_hierarchy();
		
		$collector = $tree->get_collector();
		
		$collector->select( "someclass" );
		$this->assertEquals( "src1", $collector->get_namespace( "someclass" ) );
		$collector->select( "someclass2" );
		$this->assertEquals( "src2", $collector->get_namespace( "someclass2" ) );
		
	}

	
	function test_class_and_function(){
		$tree = $this->mysetup();
		$tree->add_source( '
class someclass {}
	function fn1(){
	}
	static private function fn2( int $something, string $strong ){
	}
	abstract static function fn3() : string {
	}
}
' );
		
// 		$tree->resolve_class_hierarchy();

		$collector = $tree->get_collector();
		
		$collector->select( "someclass" );
		
		$collector->next_function();
		$this->assertEquals( "static", $collector->get_function_static() );
		
		$collector->next_function();
		$this->assertEquals( "abstract", $collector->get_function_keyword() );

		// functions parameters and return values 
		$collector->select( "someclass" );
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

	
	function test_class_and_usetrait(){
		$tree = $this->mysetup();
		$tree->add_source( '
class someclass {
	use trait1, trait2;
	function fn1(){
	}
	static private function fn2( int $something, string $strong ){
	}
	abstract static function fn3() : string {
	}
}
' );
		$collector = $tree->get_collector();
		$collector->select( "someclass" );
		$this->assertEquals( true, $collector->more_usetraits() );
		$this->assertEquals( "trait1", $collector->get_usetrait_name() );
		$collector->next_usetrait();
		$this->assertEquals( true, $collector->more_usetraits() );
		$this->assertEquals( "trait2", $collector->get_usetrait_name() );
		
	}

	
	function test_interfaces(){
		$tree = $this->mysetup();
		$tree->add_source( '
class someclass implements interface1, interface2  {
}
' );
		$collector = $tree->get_collector();
		$collector->select( "someclass" );
		
		$this->assertEquals( true, $collector->more_interfaces() );
		$collector->next_interface();
		$this->assertEquals( "interface2", $collector->get_interface_name() );
		$collector->next_interface();
		$this->assertEquals( false, $collector->more_interfaces() );
	}

	function test_abstract(){
		$tree = $this->mysetup();
		$tree->add_source( '
abstract class someclass  {
}
' );
		$collector = $tree->get_collector();
		$collector->select( "someclass" );
		
		$this->assertEquals( true, $collector->is_abstract() );
	}

	
	function test_final(){
		$tree = $this->mysetup();
		$tree->add_source( '
final class someclass  {
}
' );
		$collector = $tree->get_collector();
		$collector->select( "someclass" );
		
		$this->assertEquals( true, $collector->is_final() );
	}
	
	

}