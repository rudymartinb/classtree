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
//         var_dump( $actual );
        $this->assertEquals( "parent\n+ child\n" , $actual );
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
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );

        $this->assertEquals( "parent\n+ child\n+ child2\n" , $actual );
    }
    
    function test_get_max_width_100_classes(){
        $classes = [];
        for( $i=1; $i <= 3; $i++){
            $class = new class_("parent".$i);
            $classes[] = $class ;
            for( $j=1; $j <= 3; $j++){
                $class = new class_("son".$i."_".$j);
                $class->set_extends("parent".$i);
                $classes[] = $class ;
                for( $k=1; $k <= 3; $k ++){
                    $class = new class_("grandson".$i."_".$j."_".$k);
                    $class->set_extends("son".$i."_".$j);
                    $classes[] = $class ;
                }
                
            }
        }
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );
        var_dump($actual);
//         $this->assertEquals( "parent\n+ child\n+ child2\n" , $actual );
        
        
    }
    
    
    
    
}

