<?php

use src\class_finder;

class class_finder_Test extends PHPUnit\Framework\TestCase {
    
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

