<?php

use src\class_finder;
use function files\get_source;

class class_finder_Test extends PHPUnit\Framework\TestCase {
	function test_preg(){
		$source =" mario 1 bros 2 ";
		//		  12345678901234567
		$pattern = "/(?:[ ]*)";
		$pattern .= "(";
		$pattern .= "(?<mario>mario [0-9]*)";
		$pattern .= "(?:[ ]*)|";
		$pattern .= "(?<bros>bros [0-9]*)(?:[ ]*)){0,2}";
		
		$pattern .= "/ms";
		
		$matches = [];
		preg_match_all($pattern, $source, $matches );
// 		var_dump( $matches );
		$this->assertEquals( 2, count( $matches[0] ) );
		$this->assertEquals( "mario 1", $matches["mario"][0] );
		$this->assertEquals( "bros 2", $matches["bros"][0] );

		$source =" bros 2 mario 1 ";
// 		var_dump( $matches );
		$this->assertEquals( 2, count( $matches[0] ) );
		$this->assertEquals( "mario 1", $matches["mario"][0] );
		$this->assertEquals( "bros 2", $matches["bros"][0] );
		
	}
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

// 	function test_class_extends_and_implements(){
// 		$source = 'class test extends one implements something, else';
// 		$finder = new class_finder( $source );
		
// 		$this->assertEquals( true, $finder->more_elements() );
// 		$this->assertEquals( "test", $finder->get_name() );
// 		$this->assertEquals( "one", $finder->get_extends() );
// 		$this->assertEquals( "something, else", $finder->get_implements() );
// 	}
	
// 	function test_class_implements_extends(){
// 		$source = 'class test implements something, else extends one';
// 		$finder = new class_finder( $source );
		
// 		$this->assertEquals( true, $finder->more_elements() );
// 		$this->assertEquals( "test", $finder->get_name() );
// 		$this->assertEquals( "something, else ", $finder->get_implements() );
// 		$this->assertEquals( "one", $finder->get_extends() );
// 	}
	
	
//     function test_recover_body(){
//         $filename = "./tests/dummy/prueba.php";
//         $source = get_source( $filename );
        
//         $finder = new class_finder();
        
//         $matches = $finder->matches($source );
// //         var_dump( $matches["tipo"] );
//         $bodies = $finder->find_bodies();
// //         var_dump($bodies);
//         $classes = $finder->separar_clases();
        
// //         
// //         var_dump($matches);

//         $class = $classes[0]; // sarasa interface
        
//         $expected = '
//     function algo() : string;
//     function algo1( string $something ) : string;
//     function algo2( father $father ) : string;
// }
// ';
//         $this->assertEquals( $expected, $bodies["sarasa_interface"] );
//         $this->assertEquals( "sarasa_interface", $class->get_name() );
//         $this->assertEquals( $expected, $class->get_body() );
        
//         $class = $classes[1]; // father
//         $name = "father";
//         $expected = '
//     function algo1( int $uno, string $dos ): string {
        
//     }
    
//     function algo2( int $uno, string $dos ) {
//     }
//     function algo3( ) : bool {
//     }
//     function algo4( ) {
//     }
// }

// ';
        
//         $this->assertEquals( $name , $class->get_name() );
//         $this->assertEquals( $expected, $bodies[ $name ] );
//         $this->assertEquals( $expected, $class->get_body() );
// //         var_dump($class->get_functions());
        
        
//     }
    
    
    
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

