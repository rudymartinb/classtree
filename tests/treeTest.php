<?php

use src\class_;

function get_tree( Array $classes ){
    return $classes;
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
    }
    
       
}

