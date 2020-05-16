<?php

use src\class_;
use function src\force_class;

function get_tree( Array $classes, string $parent = "" ){
    $result = [];
    foreach( $classes as $class ){
        if( $parent != "" ){
            $class = force_class($class);
            if( $class->get_extends() != $parent ){
                continue;
            }
        }
        if( $class->get_extends() == ""){
            $result[] = [ $class->get_name(), get_tree( $classes, $class->get_name() ) ] ;
        }
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
        
        var_dump($actual);
        // theres only one three in the first element
        $this->assertEquals( 1, count( $actual ) );
        
//         $this->assertEquals( 2, count( $actual[0] ) );
//         $this->assertEquals( 2, count( $actual[1] ) );
    }
    
    
       
}

