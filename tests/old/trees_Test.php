<?php

use src\class_;
use function src\force_class;
use function files\get_source;
use function files\get_clases;
use src\Trees;


class trees_Test extends PHPUnit\Framework\TestCase {
    function test_tree_empty(){
        $classes = [];
        $tree = new Trees( $classes );
        
        $this->assertEquals( 0, $tree->count_parents() );
        $this->assertEquals( 0, $tree->total_width() );
        $this->assertEquals( 0, $tree->total_height() );
    }

    function test_tree_1(){
        $class = new class_("orphan");
        $classes = [ $class ];
        $tree = new Trees( $classes );
        
        $this->assertEquals( 1, $tree->count_parents() );
        $this->assertEquals( 1, $tree->total_width() );
        $this->assertEquals( 1, $tree->total_height() );
        
    }

    /* if the extends clause points 
     * to a non-existant class on the array
     * it wont be added to the tree / yet
     */
    function test_not_resolved_class(){
        $class = new class_("orphan");
        $class->set_extends("clueless");
        $classes = [ $class ];
        $tree = new Trees( $classes );
        
        $this->assertEquals( 0, $tree->count_parents() );
        $this->assertEquals( 0, $tree->total_width() );
        $this->assertEquals( 0, $tree->total_height() );
    }
    
    
    function test_tree_2_orphans(){
        $classes = [];
        $class = new class_("orphan");
        $classes[] = $class ;
        $class2 = new class_("orphan2");
        $classes[] = $class2;
        
        $tree = new Trees( $classes );
        
        $this->assertEquals( 2, $tree->count_parents() );
        $this->assertEquals( 2, $tree->total_width() );
        $this->assertEquals( 1, $tree->total_height() );
        
    }

    function test_parent_child(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $tree = new Trees( $classes );
        
        // only one parent at top of the tree
        $this->assertEquals( 1, $tree->count_parents() );
        $this->assertEquals( 1, $tree->total_width() );
        $this->assertEquals( 2, $tree->total_height() );
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
        
        
        $tree = new Trees( $classes );
        
        // only one parent at top of the tree
        $this->assertEquals( 1, $tree->count_parents() );
        $this->assertEquals( 2, $tree->total_width() );
        $this->assertEquals( 2, $tree->total_height() );
        
    }

    /* TODO:  what to do with this?
     * if PHP decides to implement multiple parents
     * it will probably use the comma separator 
     * like interfaces do.
     * 
    function test_tree_2parent_2children(){
        $classes = [];
        $class = new class_("father");
        $classes[] = $class ;
        $class = new class_("mother");
        $classes[] = $class ;
        
        $class2 = new class_("child");
        $class2->set_extends("father");
        $class2->set_extends("mother");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("father");
        $class3->set_extends("mother");
        $classes[] = $class3;
        
        
        $tree = new Tree( $classes );
        
        $tree->process();
        
        // only one parent at top of the tree
        $this->assertEquals( 2, $tree->count() );
    }
    */
    
    
    
//     function test_tree_parent_3levels(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
        
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("child");
//         $classes[] = $class3;
        
        
//         $actual = get_tree( $classes );
        
// //         var_dump($actual);
        
//         // theres only one tree in the first element
//         $this->assertEquals( 1, count( $actual ) );
//         $this->assertEquals( 1, count( $actual[0]["childrens"] ) );
//     }

//     function test_get_max_width_0(){
//         $classes = [];
//         $tree = get_tree( $classes );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 0, $actual );
//     }
    
//     function test_get_max_width_1(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
    
//         $tree = get_tree( $classes );
// //         var_dump($tree);
//         $actual = get_max_width( $tree );

        
//         $this->assertEquals( 1, $actual );
//     }

//     function test_get_max_width_1_2_children(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
        
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("parent");
//         $classes[] = $class3;
                
//         $tree = get_tree( $classes );
// //         var_dump( $tree );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 2, $actual );
//     }

//     function test_get_max_width_1_2_children_reversed(){
//         $classes = [];
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("parent");
//         $classes[] = $class3;
        
//         $class = new class_("parent");
//         $classes[] = $class ;
        
//         $tree = get_tree( $classes );
// //         var_dump( $tree );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 2, $actual );
//     }
    
    
    

//     function test_get_max_width_1_3_children(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
        
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("parent");
//         $classes[] = $class3;
        
//         $class4 = new class_("child3");
//         $class4->set_extends("parent");
//         $classes[] = $class3;
        
//         $tree = get_tree( $classes );
        
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 3, $actual );
//     }

//     function test_get_max_width_4_parents_3_children(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
        
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("parent");
//         $classes[] = $class3;
        
//         $class4 = new class_("child3");
//         $class4->set_extends("parent");
//         $classes[] = $class3;
        
//         $class = new class_("parent1");
//         $classes[] = $class ;
//         $class = new class_("parent2");
//         $classes[] = $class ;
//         $class = new class_("parent3");
//         $classes[] = $class ;
        
//         $tree = get_tree( $classes );
// //         var_dump( $tree );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 6, $actual );
//     }

//     function test_get_max_width_4_parents_3_children_reversed(){
//         $classes = [];
        
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("parent");
//         $classes[] = $class3;
        
//         $class4 = new class_("child3");
//         $class4->set_extends("parent");
//         $classes[] = $class3;
        
//         $class = new class_("parent1");
//         $classes[] = $class ;
//         $class = new class_("parent2");
//         $classes[] = $class ;
//         $class = new class_("parent3");
//         $classes[] = $class ;
        
//         $class = new class_("parent");
//         $classes[] = $class ;
        
        
        
//         $tree = get_tree( $classes );
//         //         var_dump( $tree );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 6, $actual );
//     }
    
    
//     function test_3x3x3() {
//         $classes = [];
//         for( $i=1; $i <= 3; $i++){
//             $class = new class_("xparent".$i);
//             $classes[] = $class ;
//             for( $j=1; $j <= 3; $j++){
//                 $class = new class_("xson".$i."_".$j);
//                 $class->set_extends("xparent".$i);
//                 $classes[] = $class ;
//                 for( $k=1; $k <= 3; $k++){
//                     $class = new class_("xgson".$i."_".$j."_".$k);
//                     $class->set_extends("xson".$i."_".$j);
//                     $classes[] = $class ;
//                 }
                
//             }
            
//         }

//         $tree = get_tree( $classes );
// //         var_dump( $tree );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 27, $actual );
        
        
//     }
    
//     /*
//      * off to the races!
//      * I want 100 parent clases with 10 children each
//      */
//     function test_get_max_width_100_classes(){
//         $classes = [];
//         for( $i=1; $i <= 100; $i++){
//             $class = new class_("parent".$i);
//             $classes[] = $class ;
//             for( $j=1; $j <= 10; $j++){
//                 $class = new class_("son".$i."_".$j);
//                 $class->set_extends("parent".$i);
//                 $classes[] = $class ;
//             }
        
//         }

//         $tree = get_tree( $classes );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 1000, $actual );
//     }
    
    
//     function test_class_interface_extends_1() {
//         $classes = [];
//         $class = new class_("myinterface");
//         $classes[] = $class; 
//         $class = new class_("myclass");
//         $classes[] = $class;
//         $class->set_implements("myinterface");
        
//         $this->assertTrue( is_child_of($class, "myinterface") );

//         $tree = get_tree( $classes );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 1, $actual );
//     }

//     function test_class_interface_extends_2_interfaces() {
//         $classes = [];
//         $class = new class_("myinterface");
//         $classes[] = $class;
//         $class = new class_("myinterface2");
//         $classes[] = $class;
        
//         $class = new class_("myclass");
//         $classes[] = $class;
        
//         // white spaces added on purpose
//         $class->set_implements(" myinterface , myinterface2 ");
        
//         $this->assertTrue( is_child_of($class, "myinterface") );
//         $this->assertTrue( is_child_of($class, "myinterface2") );
//         $this->assertFalse( is_child_of($class, "somethingelse") );
        
//         $tree = get_tree( $classes );
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 2, $actual );
//     }

//     /*
//      * 2 interfaces
//      * 1 parent
//      * 1 child
//      * 
//      * drawing should look like a "Y"
//      */
//     function test_class_extended_extends_2_interfaces() {
//         $classes = [];
//         $class = new class_("myinterface");
//         $classes[] = $class;
//         $class = new class_("myinterface2");
//         $classes[] = $class;
        
//         $class = new class_("myclass");
//         $classes[] = $class;

//         $class->set_implements(" myinterface , myinterface2 ");
        
//         $class = new class_("myextendedclass");
//         $class->set_extends("myclass");
//         $classes[] = $class;
        
//         // white spaces added on purpose
        
        
//         $this->assertTrue( is_child_of($class, "myclass") );
        
//         $tree = get_tree( $classes );
// //         var_dump($tree);
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 2, $actual );
//     }

    /*
     * 1 interface at the top
     * 2 interfaces extending the first
     * 1 class at the bottom
     *
     * drawing should look like a diamond
     */
//     function test_3interfaces_1class_diamond() {
//         $classes = [];
//         $class = new class_("myinterface0");
//         $classes[] = $class;
        
//         $class = new class_("myinterface1");
//         $classes[] = $class;
//         $class->set_implements("myinterface0");

//         $class = new class_("myinterface2");
//         $classes[] = $class;
//         $class->set_implements("myinterface0");
        
//         $class = new class_("myclass");
//         $classes[] = $class;
        
//         $class->set_implements(" myinterface1 , myinterface2 ");
        
//         // white spaces added on purpose
        
        
//         $this->assertTrue( is_child_of($class, "myinterface1") );
        
//         $tree = get_tree( $classes );
// //         var_dump($tree);
//         $actual = get_max_width( $tree );
        
//         $this->assertEquals( 2, $actual );
//     }
    
    
    
    
        
}
