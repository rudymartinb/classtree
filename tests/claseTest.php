<?php

use src\class_;
use function files\get_source;
use function files\get_clases;
use src\class_finder;


class claseTest extends PHPUnit\Framework\TestCase {

    function test_class_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $finder->matches($source );
        $classes = $finder->separar_clases();
        $this->assertEquals( "whats\\is\\this", $classes[0]->get_namespace() );
    }

    function test_interface_from_source(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $matches = $finder->matches($source );

//         var_dump( $matches );
        $this->assertEquals( "interface sarasa_interface {", $matches[0][1] );
//         $classes = $finder->separar_clases();
        
    }
    
    /* interfaces
     * 
     */
    function test_class_interface_extends_null() {
        $class = new class_("myinterface");
        $class->set_interface_extends("");
        $this->assertEquals( [""], $class->get_interface_extends() );
    }
    
    function test_class_interface_extends_2() {
        $class = new class_("myinterface");
        $class->set_interface_extends("iface1,iface2");
        $this->assertEquals( ["iface1","iface2"], $class->get_interface_extends() );
    }
    
    
}

