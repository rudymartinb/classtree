<?php

use src\class_;

function get_tree( Array $classes ){
    $result = [];
    foreach( $classes as $class ){
        $result[] = [ $class, [] ] ;
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
    
    
       
}

