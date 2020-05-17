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
        $this->assertEquals( "orphan" , $actual );
    }
    
}

