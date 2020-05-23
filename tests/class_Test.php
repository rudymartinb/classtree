<?php

use src\class_;
use function files\get_source;
use function files\get_clases;
use src\class_finder;


class class_Test extends PHPUnit\Framework\TestCase {

    function test_class_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
//         var_dump( $matches );
        $classes = $finder->separar_clases();
        $this->assertEquals( "class", $classes[0]->get_type() );
        $this->assertEquals( "whats\\is\\this", $classes[0]->get_namespace() );
        

    }

    function test_interface_from_source(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $matches = $finder->matches($source );

        $classes = $finder->separar_clases();
        
//         var_dump( $classes );
        
        $this->assertEquals( "interface sarasa_interface {", $matches[0][1] );
        $this->assertEquals( 4, count( $classes ) );
        $this->assertEquals( "interface", $classes[0]->get_type() );
//         $classes = $finder->separar_clases();
        
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
