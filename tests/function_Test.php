<?php

use src\function_;
use src\parameter_;
use src\class_finder;
use function files\get_source;


class function_Test extends PHPUnit\Framework\TestCase {
    
    
    function test_1(){
        $source = 'private function algo1( int $uno, string $dos ): string {';
        $fn = new function_( $source );
        $this->assertEquals( "algo1", $fn->get_name() );
        $this->assertEquals( 'int', $fn->get_params()[0]->get_type() );
        $this->assertEquals( '$uno', $fn->get_params()[0]->get_name() );
        $this->assertEquals( 'string', $fn->get_params()[1]->get_type() );
        $this->assertEquals( '$dos', $fn->get_params()[1]->get_name() );
        $this->assertEquals( 'string', $fn->get_return_type() );
    }
 
    function test_real() {
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
        $classes = $finder->separar_clases();
        
        //
        //         var_dump($matches);
        
        $class = $classes[1]; // sarasa interface
        $expected = 'algo1';
        $this->assertEquals( $expected, $class->get_functions()[0]["name"] );
    }
    
}

