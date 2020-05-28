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
		$source = "trait test {
function test1(){

}
}";
		$finder = new trait_finder($source);
		
		$this->assertTrue( $finder->more_elements() );
		
		$expected = "{
function test1(){

}
}";
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




