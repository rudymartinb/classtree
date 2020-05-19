<?php

use src\grid;
use src\class_;

class gridTest extends PHPUnit\Framework\TestCase {
    
    function test_1(){
        $class1 = new class_("class1");
        
        $grid = new grid();
        $grid->add_element( $class1 );
        
        $this->assertEquals(1, $grid->get_rows());
        $this->assertEquals(1, $grid->get_columns());
    }

    function test_2(){
        $class1 = new class_("class1");
        $class2 = new class_("class2");
        
        $grid = new grid();
        $grid->add_element( $class1 );
        $grid->add_element( $class2 );
        
        $this->assertEquals(1, $grid->get_rows());
        $this->assertEquals(2, $grid->get_columns());
    }

    function test_1_extends_1(){
        $class1 = new class_("class1");
        $class2 = new class_("class2");
        $class2->set_extends("class1");
        
        $grid = new grid();
        $grid->add_element( $class1 );
        $grid->add_element( $class2 );
        
        $this->assertEquals(2, $grid->get_rows());
        $this->assertEquals(1, $grid->get_columns());
    }
    
    /* a silly microtest to see how php handles keys
     */
    function test_array(){
        $arr = [ 3 => 1, 4 => 2, 1=> 3];
//         var_dump( $arr );
        $this->assertEquals( 3, array_key_first( $arr ) );
        
        $insert = [ 55 => 66 ];
        $remaining = $arr;
        $head = array_splice( $remaining, 2,1 );
        var_dump( $remaining );
        $resultado = array_merge( $head , $insert, $remaining );
//         var_dump( $resultado );
        
    }
    

//     function test_2_extends_1(){
//         $class1 = new class_("class1");
//         $class2 = new class_("class2");
//         $class2->set_extends("class1");
//         $class3 = new class_("class3");
//         $class3->set_extends("class1");
        
//         $grid = new grid();
//         $grid->add_element( $class1 );
//         $grid->add_element( $class2 );
//         $grid->add_element( $class3 );
        
//         $this->assertEquals(2, $grid->get_rows());
//         $this->assertEquals(2, $grid->get_columns());
//     }
    
    
    
}

