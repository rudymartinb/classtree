<?php

use src\class_;
use function files\get_source;
use function files\get_clases;

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
    
    function test_1_implements_1(){
        $class = new class_("orphan");
        $class->set_implements("imp1");
        $classes = [ $class ];
        $tree = get_tree( $classes );
//         var_dump( $tree );
        
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

    function test_1_namespace(){
        $class = new class_("orphan");
        $class->set_namespace("whats\\this");
        $classes = [ $class ];
        $tree = get_tree( $classes );
        //         var_dump( $tree );
        
        $actual = textoutput( $tree );
        $this->assertEquals( "orphan (NS: whats\\this)\n" , $actual );
    }

    function test_1_namespace_2(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        $classes = get_clases( $source );
        $tree = get_tree( $classes );
        
        $actual = textoutput( $tree );
        $this->assertEquals( "algo (NS: whats\\is\\this)\n" , $actual );
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
        
        $this->assertEquals( "parent\n+-child\n" , $actual );
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
//         echo "\n". $actual;
        $this->assertEquals( "parent\n+-child\n+-child2\n" , $actual );
    }

    function test_tree_parent_1children_1grand(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        $class2 = new class_("child");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child2");
        $class3->set_extends("child");
        $classes[] = $class3;
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );
//         echo "\n". $actual;
        $this->assertEquals( "parent\n+-child\n  +-child2\n" , $actual );
    }

    function test_tree_parent_2children_2grand(){
        $classes = [];
        $class = new class_("parent");
        $classes[] = $class ;
        $class2 = new class_("child1");
        $class2->set_extends("parent");
        $classes[] = $class2;
        
        $class3 = new class_("child11");
        $class3->set_extends("child1");
        $classes[] = $class3;
        
        $class4 = new class_("child2");
        $class4->set_extends("parent");
        $classes[] = $class4;
        
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );
//         echo "\n". $actual;
        $expected = 
"parent
+-child1
| +-child11
+-child2\n";

        $this->assertEquals( $expected , $actual );
    }
    
    
    
    function test_too_many_classes(){
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
                    for( $l=1; $l <= 3; $l ++){
                        $class = new class_("grandgrandson".$i."_".$j."_".$k);
                        $class->set_extends("grandson".$i."_".$j."_".$k);
                        $classes[] = $class ;
                    }
                }
                
            }
        }
        
        $tree = get_tree( $classes );
        $actual = textoutput( $tree );
//         echo "\n". $actual;
        $expected = "parent1
 +son1_1
 | +grandson1_1_1
 | +grandson1_1_2
 | +grandson1_1_3
 +son1_2
 | +grandson1_2_1
 | +grandson1_2_2
 | +grandson1_2_3
 +son1_3
   +grandson1_3_1
   +grandson1_3_2
   +grandson1_3_3
parent2
 +son2_1
 | +grandson2_1_1
 | +grandson2_1_2
 | +grandson2_1_3
 +son2_2
 | +grandson2_2_1
 | +grandson2_2_2
 | +grandson2_2_3
 +son2_3
   +grandson2_3_1
   +grandson2_3_2
   +grandson2_3_3
parent3
 +son3_1
 | +grandson3_1_1
 | +grandson3_1_2
 | +grandson3_1_3
 +son3_2
 | +grandson3_2_1
 | +grandson3_2_2
 | +grandson3_2_3
 +son3_3
   +grandson3_3_1
   +grandson3_3_2
   +grandson3_3_3
";
        $this->assertNotEquals( "", $actual );
    }
    
    
    
    
}

