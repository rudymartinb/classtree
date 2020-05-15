<?php
use function files\get_all_files;
use function files\get_source;
use function files\get_sources;
use src\ClassDiagram;
use src\class_;

// use src\clase;
// use src\ClassDiagram;

class ClassDiagramTest extends PHPUnit\Framework\TestCase {

    function test_class_with_no_extends(){
        $diagram = new ClassDiagram();
        
        $class = new class_("parent");
        $diagram->addClass( $class );
        
        
        $this->assertTrue( $class->is_extends_resolved(), "subclass has no extends");
    }
    
    
    function test_is_extends_resolved(){
        $diagram = new ClassDiagram();
        
        $class = new class_("parent");
        $diagram->addClass( $class );
        
        
        $class2 = new class_("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_extends( $diagram->get_classes() );
        
        $this->assertTrue( $class2->is_extends_resolved(), "subclass is now linked with parent");
    }
    
    
    function test_is_extends_resolved_and_same_obj(){
        $diagram = new ClassDiagram();
        
        $class = new class_("parent");
        $diagram->addClass( $class );
        
        $class2 = new class_("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_extends( $diagram->get_classes() );
        
        $this->assertTrue( $class2->get_extends_class() === $class, "subclass is now linked with parent");

    }
    
    function test_is_NOT_resolved_2(){
        $diagram = new ClassDiagram();
        
        $class2 = new class_("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_extends( $diagram->get_classes() );
        
        $this->assertFalse( $class2->is_extends_resolved(), "subclass not resolved");
    }


    
    

}

