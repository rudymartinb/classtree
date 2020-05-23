<?php

use src\class_;
use function files\get_source;
use function files\get_clases;
use src\class_finder;
use function src\textoutput;
use function src\get_tree;

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
//         var_dump( $tree );
        $actual = textoutput( $tree );
        $this->assertEquals( "orphan\n" , $actual );
    }
    
    function test_1_implements_1(){
        $class = new class_("imp1");
        $class->set_type("interface");
        $classes = [ $class ];
        
        $class = new class_("orphan");
        $class->set_implements("imp1");
        $classes[] = $class ;
        
        $tree = get_tree( $classes );
        var_dump( $tree );
        
        $actual = textoutput( $tree );
        $this->assertEquals( "orphan (Implements: imp1)\n" , $actual );
    }
    function test_1_abstract(){
        $class = new class_("orphan");
        $class->set_abstract("abstract");
        $classes = [ $class ];
        $tree = get_tree( $classes );
//                 var_dump( $tree );
        
        $actual = textoutput( $tree );
        $this->assertEquals( "orphan (abstract)\n" , $actual );
    }
    function test_1_final(){
        $class = new class_("orphan");
        $class->set_final("final");
        $classes = [ $class ];
        $tree = get_tree( $classes );
//         var_dump( $tree );
        
        $actual = textoutput( $tree );
        $this->assertEquals( "orphan (final)\n" , $actual );
    }

//     function test_1_namespace(){
//         $class = new class_("orphan");
//         $class->set_namespace("whats\\this");
//         $classes = [ $class ];
//         $tree = get_tree( $classes );
//         //         var_dump( $tree );
        
//         $actual = textoutput( $tree );
//         $this->assertEquals( "orphan (NS: whats\\this)\n" , $actual );
//     }

//     function test_1_namespace_2(){
//         $filename = "./tests/dummy/prueba2.php";
//         $source = get_source( $filename );
        
//         $finder = new class_finder();
//         $finder->matches($source);
//         $classes = $finder->separar_clases();
//         $tree = get_tree( $classes );
        
//         $actual = textoutput( $tree );
//         $this->assertEquals( "algo (NS: whats\\is\\this)\n" , $actual );
//     }
    
    
//     function test_tree_2_orphans(){
//         $classes = [];
//         $class = new class_("orphan");
//         $classes[] = $class ;
//         $class2 = new class_("orphan2");
//         $classes[] = $class2;
        
//         $tree = get_tree( $classes );
//         $actual = textoutput( $tree );
        
//         $this->assertEquals( "orphan\norphan2\n" , $actual );
        
//     }
    
//     function test_tree_parent_child(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $tree = get_tree( $classes );
//         $actual = textoutput( $tree );
        
//         $this->assertEquals( "parent\n+-child\n" , $actual );
//     }
    
//     function test_tree_parent_2children(){
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
//         $actual = textoutput( $tree );
// //         echo "\n". $actual;
//         $this->assertEquals( "parent\n+-child\n+-child2\n" , $actual );
//     }

//     function test_tree_parent_1children_1grand(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
//         $class2 = new class_("child");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child2");
//         $class3->set_extends("child");
//         $classes[] = $class3;
        
//         $tree = get_tree( $classes );
//         $actual = textoutput( $tree );
// //         echo "\n". $actual;
//         $this->assertEquals( "parent\n+-child\n  +-child2\n" , $actual );
//     }

//     function test_tree_parent_2children_2grand(){
//         $classes = [];
//         $class = new class_("parent");
//         $classes[] = $class ;
//         $class2 = new class_("child1");
//         $class2->set_extends("parent");
//         $classes[] = $class2;
        
//         $class3 = new class_("child11");
//         $class3->set_extends("child1");
//         $classes[] = $class3;
        
//         $class4 = new class_("child2");
//         $class4->set_extends("parent");
//         $classes[] = $class4;
        
        
//         $tree = get_tree( $classes );
//         $actual = textoutput( $tree );
// //         echo "\n". $actual;
//         $expected = 
// "parent
// +-child1
// | +-child11
// +-child2\n";

//         $this->assertEquals( $expected , $actual );
//     }
    
    
    // remove the comments to see how the text tree would look like
//     function test_too_many_classes(){
//         $classes = [];
//         for( $i=1; $i <= 3; $i++){
//             $class = new class_("parent".$i);
//             $classes[] = $class ;
//             for( $j=1; $j <= 3; $j++){
//                 $class = new class_("son".$i."_".$j);
//                 $class->set_extends("parent".$i);
//                 $classes[] = $class ;
//                 for( $k=1; $k <= 3; $k ++){
//                     $class = new class_("grandson".$i."_".$j."_".$k);
//                     $class->set_extends("son".$i."_".$j);
//                     $classes[] = $class ;
//                     for( $l=1; $l <= 3; $l ++){
//                         $class = new class_("grandgrandson".$i."_".$j."_".$k);
//                         $class->set_extends("grandson".$i."_".$j."_".$k);
//                         $classes[] = $class ;
//                     }
//                 }
//             }
//         }
//         $tree = get_tree( $classes );
//         $actual = textoutput( $tree );
//         echo "\n". $actual;
//         $this->assertNotEquals( "", $actual );
//     }
    
    
    
    
}

