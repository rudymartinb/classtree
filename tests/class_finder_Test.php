<?php

use src\class_finder;
use function files\get_source;
/*
 * for readability I ended up leaving the $expected variables as multilines
 * but be careful when formatting with tab because it will break the tests
 * 
 */
class class_finder_Test extends PHPUnit\Framework\TestCase {
	
	function test_zero(){
		$source = '';
		
		$finder = new class_finder( $source );
		
		$this->assertEquals( false, $finder->more_elements() );
	}
	
	function test_bare_class(){
		$source = 'class test {}';
		$finder = new class_finder( $source );
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
	}

	function test_class_extends(){
		$source = 'class test extends something ';
		$finder = new class_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		$this->assertEquals( "something", $finder->get_extends() );
	}

	function test_class_implements(){
		$source = 'class test implements something';
		$finder = new class_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		$this->assertEquals( "something", $finder->get_implements() );
	}

	function test_class_implements_2(){
		$source = 'class test implements something, else';
		$finder = new class_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		$this->assertEquals( "something, else", $finder->get_implements() );
	}

	function test_class_extends_and_implements(){
		$source = 'class test extends one implements something, else';
		$finder = new class_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "test", $finder->get_name() );
		$this->assertEquals( "one", $finder->get_extends() );
		$this->assertEquals( "something, else", $finder->get_implements() );
	}
	
	
	
    function test_body_1_class(){
        $source = 'class test 
{
function test1(){
}
}';
        
        $finder = new class_finder($source);

        $this->assertEquals( true, $finder->more_elements() );
        $this->assertEquals( "test", $finder->get_name() );
        
        $expected = '{
function test1(){
}
}';
        $this->assertEquals( $expected, $finder->get_body() );
    }

    function test_body_2_classes(){
    	$source = 'class test {
function test1(){
}
}
class test2 {
function test2(){
}
}';
    	
    	$finder = new class_finder($source);
    	
    	$this->assertEquals( true, $finder->more_elements() );
    	$this->assertEquals( "test", $finder->get_name() );
    	$finder->next();
    	
    	$expected = '{
function test2(){
}
}';
//     	var_dump($finder->matches($source)[0]);
    	$this->assertEquals( $expected, $finder->get_body() );
    	$this->assertEquals( "test2", $finder->get_name() );
    	
    	
    }
    
    function test_abstract(){
        $source = "abstract class Caso00_Builder implements builder_interface, builder_getcaso {
}";
        
        $finder = new class_finder( $source );
        $this->assertEquals( "Caso00_Builder", $finder->get_name() );
        $this->assertEquals( "builder_interface, builder_getcaso", $finder->get_implements() );
        $this->assertEquals( "abstract", $finder->get_abstract() );
    }

    
    function test_final(){
    	$source = "final class afinalclass extends other_class {
}";
    	
    	$finder = new class_finder( $source );
    	$this->assertEquals( "afinalclass", $finder->get_name() );
    	$this->assertEquals( "other_class", $finder->get_extends() );
    	$this->assertEquals( "final", $finder->get_final() );
    }

    function test_namespace_1(){
    	$source = "
abstract class afinalclass extends other_class {
}";
    	
    	$namespace = "nstest1";
    	$finder = new class_finder( $source, $namespace );
    	$this->assertEquals( "afinalclass", $finder->get_name() );
    	$this->assertEquals( "other_class", $finder->get_extends() );
    	$this->assertEquals( "abstract", $finder->get_abstract() );
    	$this->assertEquals( "nstest1", $finder->get_namespace() );
    }
    
    
    function test_very_weird(){
    	$source = "final 
class 
afinalclass 
extends 
other_class {
}";
    	
    	$finder = new class_finder( $source );
    	$this->assertEquals( "afinalclass", $finder->get_name() );
    	$this->assertEquals( "other_class", $finder->get_extends() );
    	$this->assertEquals( "final", $finder->get_final() );
    }
    
    function test_very_weird_2(){
    	$source = "abstract
class
afinalclass
extends
other_class {
}";
    	
    	$finder = new class_finder( $source );
    	$this->assertEquals( "afinalclass", $finder->get_name() );
    	$this->assertEquals( "other_class", $finder->get_extends() );
    	$this->assertEquals( "abstract", $finder->get_abstract() );
    }
    

    
}

