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
    
    

    function test_2_parent_1_child(){
        $class1 = new class_("parent1");
        $class2 = new class_("parent2");
        
        $class3 = new class_("child");
        $class3->set_extends("parent1");
        $class3->set_extends("parent2");
        
        $grid = new grid();
        $grid->add_element( $class1 );
        $grid->add_element( $class2 );
        $grid->add_element( $class3 );
        
        $this->assertEquals(3, $grid->get_num_elements());
//         $this->assertEquals(2, $grid->get_columns());
    }
    
    
    
}

