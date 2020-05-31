<?php

use src\trait_finder;

class trait_finder_Test extends PHPUnit\Framework\TestCase {
	function test_nothing(){
		$source = "";
		$finder = new trait_finder($source);
		
		$this->assertFalse( $finder->more_elements() );
		
	}

	function test_name(){
		$source = "trait test {}";
		$finder = new trait_finder($source);
		
		$this->assertTrue( $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		
	}

	
	function test_body(){
		$expected = "{
function test1(){
				
}
}";
		$source = "trait test".$expected;
		$finder = new trait_finder($source);
		
		$this->assertTrue( $finder->more_elements() );
		$this->assertEquals( $expected, $finder->get_body() );
	}
	
	function test_body_2(){
		$source = "trait test {
function test1(){
				
}
}
trait test2 {
function test2(){
}
}
class mytest_class {

";
		$this->run_test_2bodies($source);
	}
	
	
	function test_body_with_namespace(){
		$source = "trait test {
function test1(){
				
}
}
trait test2 {
function test2(){
}
}
namespace mytest_class {
				
";
		$this->run_test_2bodies($source);
	}
	
	function test_body_with_interface(){
		$source = "trait test {
function test1(){
				
}
}
trait test2 {
function test2(){
}
}
interface mytest_class {
				
";
		$this->run_test_2bodies($source);
	}
	
	function test_functions(){
		$body = '{
function something1();
function something2( int $ant, string $strong );
}';
		$source = 'trait myif '.$body;
		
		$finder = new trait_finder( $source );
		
		// function something1
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "myif", $finder->get_name() );
		$this->assertEquals( true, $finder->has_functions() );
		$this->assertEquals( "something1", $finder->get_function_name() );
		$this->assertEquals( false, $finder->has_parameters() );
		$finder->next_function();
		$this->assertEquals( "something2", $finder->get_function_name() );
		$finder->next_parameter();
		$this->assertEquals( true, $finder->has_parameters() );
		$this->assertEquals( "int", $finder->get_parameter_type() );
		$this->assertEquals( "ant", $finder->get_parameter_name() );
		
	}
	
	
	function run_test_2bodies( string $source ){
		$finder = new trait_finder($source);
		
		$this->assertTrue( $finder->more_elements() );
		
		$expected = "{
function test1(){
				
}
}
";
		$this->assertEquals( $expected, $finder->get_body() );
		
		$finder->next();
		$expected ="{
function test2(){
}
}
";
		$this->assertEquals( $expected, $finder->get_body() );
		
	}
	
	
	
	
}




