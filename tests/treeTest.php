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
    
       
}

