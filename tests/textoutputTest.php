<?php

use src\class_;

/**
 * goal is to convert the tree data into a text file
 */
class textoutputTest extends PHPUnit\Framework\TestCase {
    function test_null(){
        $tree = [];
        $actual = textoutput( $tree );
        $this->assertEquals( "" , $actual );
    }

    function test_1(){
        $class = new class_("orphan");
        $classes = [ $class ];
        $tree = get_tree( $classes );
        
        $actual = textoutput( $tree );
        $this->assertEquals( "orphan\n" , $actual );
    }
    
    function test_tree_2_orphans(){
        $classes = [];
        $class = new class_("orphan");
        $classes[] = $class ;
        $class2 = new class_("orphan2");
        $classes[] = $class2;
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );
        
        $this->assertEquals( "orphan\norphan2\n" , $actual );
        
    }
    
    function test_tree_parent_child(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );
        var_dump( $actual );
        $this->assertEquals( "parent\n+ child\n" , $actual );
    }
    
    
}

