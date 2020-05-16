<?php

use src\class_;
use function src\force_class;

function get_tree( Array $classes, string $parent = "" ){
    $result = [];
    foreach( $classes as $class ){
        if( $parent != "" ){
            $class = force_class($class);
            if( $class->get_extends() !== $parent ){
                continue;
            }
        } else {
            if( $class->get_extends() != ""){
                continue;
            }
        }
        $result[] = [ "name" => $class->get_name(), "childrens" => get_tree( $classes, $class->get_name() ) ] ;
    }
    return  $result;
}

class treeTest extends PHPUnit\Framework\TestCase {
    function test_tree_empty(){
        $classes = [];
        $actual = get_tree( $classes );
        $this->assertEquals( 0, count( $actual ) );
    }

    function test_tree_1(){
        $class = new class_("orphan");
        $classes = [ $class ];
        $actual = get_tree( $classes );
        $this->assertEquals( 1, count( $actual ) );
        
        $this->assertEquals( 2, count( $actual[0] ) );
    }

    /* if the extends clause points to a non-existant class
     * it wont be added to the tree / yet
     */
    function test_not_resolved_class(){
        $class = new class_("orphan");
        $class->set_extends("clueless");
        $classes = [ $class ];
        $actual = get_tree( $classes );
        $this->assertEquals( 0, count( $actual ) );
    }
    
    
    function test_tree_2_orphans(){
        $classes = [];
        $class = new class_("orphan");
        $classes[] = $class ;
        $class2 = new class_("orphan2");
        $classes[] = $class2;
        
        $actual = get_tree( $classes );
        $this->assertEquals( 2, count( $actual ) );
        
        $this->assertEquals( 2, count( $actual[0] ) );
        $this->assertEquals( 2, count( $actual[1] ) );
    }

    function test_tree_parent_child(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $actual = get_tree( $classes );
        
//         var_dump($actual);
        
        // theres only one tree in the first element
        $this->assertEquals( 1, count( $actual ) );
        $this->assertEquals( 1, count( $actual[0]["childrens"] ) );
    }

    function test_tree_parent_2children(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("parent");
        $classes[] = $class3;
        
        
        $actual = get_tree( $classes );
        
//         var_dump($actual);
        
        // theres only one tree in the first element
        $this->assertEquals( 1, count( $actual ) );
        $this->assertEquals( 2, count( $actual[0]["childrens"] ) );
    }

    function test_tree_parent_3levels(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("child");
        $classes[] = $class3;
        
        
        $actual = get_tree( $classes );
        
        var_dump($actual);
        
        // theres only one tree in the first element
        $this->assertEquals( 1, count( $actual ) );
        $this->assertEquals( 1, count( $actual[0]["childrens"] ) );
    }
    
    
       
}

