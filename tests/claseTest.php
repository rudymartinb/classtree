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

    function test_grep_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $classes = get_clases( $source );
        $this->assertEquals( "whats\\is\\this", $classes[0]->get_namespace() );
    }
    
    
}

