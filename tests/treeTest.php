<?php

use src\class_;
use function src\force_class;

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
        
//         $this->assertEquals( 2, count( $actual[0] ) );
    }

    /* if the extends clause points 
     * to a non-existant class on the array
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
        
//         $this->assertEquals( 2, count( $actual[0] ) );
//         $this->assertEquals( 2, count( $actual[1] ) );
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
        
//         var_dump($actual);
        
        // theres only one tree in the first element
        $this->assertEquals( 1, count( $actual ) );
        $this->assertEquals( 1, count( $actual[0]["childrens"] ) );
    }

    function test_get_max_width_0(){
        $classes = [];
        $tree = get_tree( $classes );
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 0, $actual );
    }
    
    function test_get_max_width_1(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
    
        $tree = get_tree( $classes );
//         var_dump($tree);
        $actual = get_max_width( $tree );

        
        $this->assertEquals( 1, $actual );
    }

    function test_get_max_width_1_2_children(){
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
//         var_dump( $tree );
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 2, $actual );
    }

    function test_get_max_width_1_2_children_reversed(){
        $classes = [];
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("parent");
        $classes[] = $class3;
        
        $class = new class_("parent");
        $classes[] = $class ;
        
        $tree = get_tree( $classes );
        //         var_dump( $tree );
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 2, $actual );
    }
    
    
    

    function test_get_max_width_1_3_children(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("parent");
        $classes[] = $class3;
        
        $class4 = new class_("child3");
        $class4->set_extends("parent");
        $classes[] = $class3;
        
        $tree = get_tree( $classes );
        
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 3, $actual );
    }

    function test_get_max_width_4_parents_3_children(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("parent");
        $classes[] = $class3;
        
        $class4 = new class_("child3");
        $class4->set_extends("parent");
        $classes[] = $class3;
        
        $class = new class_("parent1");
        $classes[] = $class ;
        $class = new class_("parent2");
        $classes[] = $class ;
        $class = new class_("parent3");
        $classes[] = $class ;
        
        $tree = get_tree( $classes );
//         var_dump( $tree );
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 6, $actual );
    }

    function test_get_max_width_4_parents_3_children_reversed(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("parent");
        $classes[] = $class3;
        
        $class4 = new class_("child3");
        $class4->set_extends("parent");
        $classes[] = $class3;
        
        $class = new class_("parent1");
        $classes[] = $class ;
        $class = new class_("parent2");
        $classes[] = $class ;
        $class = new class_("parent3");
        $classes[] = $class ;
        
        $tree = get_tree( $classes );
        //         var_dump( $tree );
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 6, $actual );
    }
    
    /*
     * off to the races!
     * I want 100 parent clases with 10 children each
     */
    function test_get_max_width_100_classes(){
        $classes = [];
        for( $i=1; $i <= 100; $i++){
            $class = new class_("parent".$i);
            $classes[] = $class ;
            for( $j=1; $j <= 10; $j++){
                $class = new class_("son".$i."_".$j);
                $class->set_extends("parent".$i);
                $classes[] = $class ;
            }
        
        }

        $tree = get_tree( $classes );
        $actual = get_max_width( $tree );
        
        $this->assertEquals( 1000, $actual );
    }
        
}

