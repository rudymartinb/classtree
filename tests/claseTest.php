<?php

use src\class_;
use function files\get_source;
use function files\get_clases;
use src\class_finder;


class claseTest extends PHPUnit\Framework\TestCase {
    function test_orphan(){
        $class = new class_("parent");
        $this->assertTrue( $class->is_extends_resolved(), "class does not have dependencies");
    }

    function test_is_parent(){
        $class = new class_("parent");
        $this->assertTrue( $class->is_parent(), "class is parent");
    }
    
    
    function test_parent_not_resolved(){
        $class2 = new class_("child");
        $class2->set_extends( "parent" );
        
        $this->assertFalse( $class2->is_extends_resolved(), "subclass is not linked with parent yet");
    }

    function test_class_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $finder->matches($source );
        $classes = $finder->separar_clases();
        $this->assertEquals( "whats\\is\\this", $classes[0]->get_namespace() );
    }

    function test_interface(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $matches = $finder->matches($source );

//         var_dump( $matches );
        $this->assertEquals( "interface sarasa_interface {", $matches[0][1] );
//         $classes = $finder->separar_clases();
        
        
    }
    
    
}

