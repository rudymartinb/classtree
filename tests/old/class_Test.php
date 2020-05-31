<?php

use src\class_;
use function files\get_source;
use function files\get_clases;
use src\class_finder;
use function src\force_class;

class class_Test extends PHPUnit\Framework\TestCase {

//     function test_between_strings(){
//         $source = "ABCD 123456789 DEFG";
//         $this->assertEquals(" 123456789 ", get_between_strings($source, "ABCD", "DEFG"));
//     }

    function test_class_1(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
//      var_dump( $matches );
        $classes = $finder->separar_clases();
        
        $class = $classes[1];
        $this->assertEquals( 'father', $class->get_name() );
        
    }
    
    
    

    function test_from_source(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $matches = $finder->matches($source );

        $classes = $finder->separar_clases();
        
        $this->assertEquals( "interface sarasa_interface {", $matches[0][1] );
        $this->assertEquals( 4, count( $classes ) );
        $this->assertEquals( "interface", $classes[0]->get_type() );

    }
    
    
    function test_class_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
        //         var_dump( $matches );
        $classes = $finder->separar_clases();
        
        $class = force_class($classes[0]);
        
        $this->assertEquals( "class", $classes[0]->get_type() );
        $this->assertEquals( "whats\\is\\this", $classes[0]->get_namespace() );
        
//         $this->assertEquals( 2, count( $class->get_functions() ) );
       
    }
    
    /* interfaces
     * 
     */
    function test_class_interface_extends_null() {
        $class = new class_("myinterface");
        $class->set_implements("");
        $this->assertEquals( [""], $class->get_implements() );
    }

    function test_class_extends_2() {
//         $class1 = new class_("parent1");
//         $class2 = new class_("parent1");
        $class3 = new class_("child1");
        $class3->set_extends("parent1");
        $class3->set_extends("parent2");
        
        $this->assertEquals( ["parent1","parent2"], $class3->get_extends() );
    }
    
    
    function test_class_interface_extends_2() {
        $class = new class_("myinterface");
        $class->set_implements("iface1,iface2");
        $this->assertEquals( ["iface1","iface2"], $class->get_implements() );
    }
    
    
}

