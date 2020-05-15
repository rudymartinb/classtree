<?php
use function files\get_all_files;
use function files\get_source;
use function files\get_sources;
use src\ClassDiagram;
use src\clase;

// use src\clase;
// use src\ClassDiagram;

class ClassDiagramTest extends PHPUnit\Framework\TestCase {

    
    function test_is_resolved(){
        $diagram = new ClassDiagram();
        
        $class = new clase("parent");
        $diagram->addClass( $class );
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_parent( $diagram->get_classes() );
        
        $this->assertTrue( $class2->is_extends_resolved(), "subclass is now linked with parent");
    }
    
    function test_is_resolved_and_same_obj(){
        $diagram = new ClassDiagram();
        
        $class = new clase("parent");
        $diagram->addClass( $class );
        
        $isacopy = $class;
        $fake = new clase("parent");
        
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_parent( $diagram->get_classes() );
        
        $this->assertTrue( $class2->get_parent() === $class, "subclass is now linked with parent");
        $this->assertTrue( $class2->get_parent() === $isacopy, "subclass shoudl be linked with a copy of parent");
        $this->assertFalse( $class2->get_parent() === $fake, "subclass is now linked with parent");
    }
    
    
    function test_is_NOT_resolved_2(){
        $diagram = new ClassDiagram();
        
        //         $class = new clase("parent");
        //         $diagram->addClass( $class );
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_parent( $diagram->get_classes() );
        
        $this->assertFalse( $class2->is_extends_resolved(), "subclass is now linked with parent");
    }
    

}

