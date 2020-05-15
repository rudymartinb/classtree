<?php

use src\clase;
use src\ClassDiagram;

class claseTest extends PHPUnit\Framework\TestCase {
    function test_orphan(){
        $class = new clase("parent");
        $this->assertTrue( $class->is_extends_resolved(), "class does not have dependencies");
    }
    
    function test_parent_not_resolved(){
        $class2 = new clase("child");
        $class2->set_extends( "parent" );
        
        $this->assertFalse( $class2->is_extends_resolved(), "subclass is not linked with parent yet");
        
    }

    
    
}

