<?php

use src\class_finder;
use function files\get_source;

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
	
	
	
    function test_body_1(){
        $source = 'class test 
{
function test1(){
}
}';
        
        $finder = new class_finder($source);

        $this->assertEquals( true, $finder->more_elements() );
        $this->assertEquals( "test", $finder->get_name() );
        
        $expected = '
{
function test1(){
}
}';
        $this->assertEquals( $expected, $finder->get_body() );
    }

    function test_body_2(){
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
    
    
    
//     /// PREG
//     function test_grep_2(){
//         $source = "abstract class Caso00_Builder implements builder_interface, builder_getcaso {";
        
//         $finder = new class_finder();
//         $matches = $finder->matches($source);
        
//         $this->assertEquals( "abstract class Caso00_Builder implements builder_interface, builder_getcaso {", $matches[0][0] );
//     }
    
//     function test_grep_abstract(){
//         $source = "abstract class Caso00_Builder implements builder_interface, builder_getcaso {";
        
//         $finder = new class_finder();
//         $matches = $finder->matches($source);
        
//         $this->assertEquals( "abstract", $matches["abstract"][0] );
//     }
    
//     function test_grep_final(){
//         $source = "final class Caso00_Builder implements builder_interface, builder_getcaso {";
        
//         $finder = new class_finder();
//         $matches = $finder->matches($source);
        
//         $this->assertEquals( "final", $matches["final"][0] );
//     }
    
//     function test_grep_namespace(){
//         $filename = "./tests/dummy/prueba2.php";
//         $source = get_source( $filename );
        
//         $finder = new class_finder();
//         $matches = $finder->matches($source);
        
//         $this->assertEquals( "whats\\is\\this", $matches["nsname"][0] );
//     }
    
}

