<?php

use src\clase;
use src\ClassDiagram;

class claseTest extends PHPUnit\Framework\TestCase {
    function test_parent(){
        $diagram = new ClassDiagram();
        
        $class = new clase("parent");
        $diagram->addClass( $class );
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $this->assertFalse( $class2->is_resolved(), "subclass is not linked with parent yet");
        
        
    }
}

