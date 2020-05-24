<?php

use src\class_finder;
use function files\get_source;

class class_finder_Test extends PHPUnit\Framework\TestCase {
    function test_recover_body(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
        var_dump( $matches["tipo"] );
        $bodies = $finder->find_bodies();
        var_dump($bodies);
        $classes = $finder->separar_clases();
        
//         
//         var_dump($matches);

        $class = $classes[0]; // sarasa interface
        
        $expected = '
    function algo() : string;
    function algo1( string $something ) : string;
    function algo2( father $father ) : string;
}
';
        $this->assertEquals( $expected, $bodies["sarasa_interface"] );
        $this->assertEquals( "sarasa_interface", $class->get_name() );
        $this->assertEquals( $expected, $class->get_body() );
        
        $class = $classes[1]; // father
        $name = "father";
        $expected = '
    function algo1( int $uno, string $dos ): string {
        
    }
    
    function algo2( int $uno, string $dos ) {
    }
    function algo3( ) : bool {
    }
    function algo4( ) {
    }
}

';
        
        $this->assertEquals( $name , $class->get_name() );
        $this->assertEquals( $expected, $bodies[ $name ] );
        $this->assertEquals( $expected, $class->get_body() );
        
        
    }
    
    
    
    /// PREG
    function test_grep_2(){
        $source = "abstract class Caso00_Builder implements builder_interface, builder_getcaso {";
        
        $finder = new class_finder();
        $matches = $finder->matches($source);
        
        $this->assertEquals( "abstract class Caso00_Builder implements builder_interface, builder_getcaso {", $matches[0][0] );
    }
    
    function test_grep_abstract(){
        $source = "abstract class Caso00_Builder implements builder_interface, builder_getcaso {";
        
        $finder = new class_finder();
        $matches = $finder->matches($source);
        
        $this->assertEquals( "abstract", $matches["abstract"][0] );
    }
    
    function test_grep_final(){
        $source = "final class Caso00_Builder implements builder_interface, builder_getcaso {";
        
        $finder = new class_finder();
        $matches = $finder->matches($source);
        
        $this->assertEquals( "final", $matches["final"][0] );
    }
    
    function test_grep_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $matches = $finder->matches($source);
        
        $this->assertEquals( "whats\\is\\this", $matches["nsname"][0] );
    }
    
}

