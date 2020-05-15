<?php

use src\class_;


class claseTest extends PHPUnit\Framework\TestCase {
    function test_orphan(){
        $class = new class_("parent");
        $this->assertTrue( $class->is_extends_resolved(), "class does not have dependencies");
    }
    
    function test_parent_not_resolved(){
        $class2 = new class_("child");
        $class2->set_extends( "parent" );
        
        $this->assertFalse( $class2->is_extends_resolved(), "subclass is not linked with parent yet");
        
    }

    
    
}

