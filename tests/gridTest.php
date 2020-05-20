<?php

use src\grid;
use src\class_;

class gridTest extends PHPUnit\Framework\TestCase {

    
    function test_1(){
        $class1 = new class_("class1");
        
        $grid = new grid();
        $grid->add_element( $class1 );
        
        $grid->distribute();
        
        $this->assertEquals(1, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("class1"));
        $this->assertEquals(1, $grid->get_pos_x("class1"));
        $this->assertEquals(1, $grid->get_pos_y("class1"));
        
    }

    function test_2(){
        $parent1 = new class_("mother");
        $parent2 = new class_("father");
        
        $grid = new grid();
        $grid->add_element( $parent1 );
        $grid->add_element( $parent2 );
        
        $grid->distribute();
        
        $this->assertEquals(2, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("mother"));
        $this->assertEquals(1, $grid->get_pos_x("mother"));
        $this->assertEquals(1, $grid->get_pos_y("mother"));
        
        $this->assertEquals( true, $grid->is_placed("father"));
        $this->assertEquals(2, $grid->get_pos_x("father"));
        $this->assertEquals(1, $grid->get_pos_y("father"));
        
    }

    function test_1_extends_1(){
        $parent = new class_("parent");
        $child = new class_("child");
        $child->set_extends("parent");
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child );
        
        $grid->distribute();
        
        $this->assertEquals(2, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(1, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child"));
        $this->assertEquals(1, $grid->get_pos_x("child"));
        $this->assertEquals(2, $grid->get_pos_y("child"));
        
    }
    

    function test_1parent2children(){
        $parent = new class_("parent");
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child1->set_extends("parent");
        $child2->set_extends("parent");
        
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        
        $grid->distribute();
        
        $this->assertEquals(3, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(1, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child1"));
        $this->assertEquals(1, $grid->get_pos_x("child1"));
        $this->assertEquals(2, $grid->get_pos_y("child1"));
        
        $this->assertEquals( true, $grid->is_placed("child2"));
        $this->assertEquals(2, $grid->get_pos_x("child2"));
        $this->assertEquals(2, $grid->get_pos_y("child2"));
        
    }

    function test_1parent2children1orphan(){
        $parent = new class_("parent");
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child1->set_extends("parent");
        $child2->set_extends("parent");
        
        $parent2 = new class_("parent2");
        
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        $grid->add_element( $parent2 );
        
        $grid->distribute();

//         var_dump($grid->get_classes());
        
        $this->assertEquals(4, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(1, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child1"));
        $this->assertEquals(1, $grid->get_pos_x("child1"));
        $this->assertEquals(2, $grid->get_pos_y("child1"));
        
        $this->assertEquals( true, $grid->is_placed("child2"));
        $this->assertEquals(2, $grid->get_pos_x("child2"));
        $this->assertEquals(2, $grid->get_pos_y("child2"));

        $this->assertEquals( true, $grid->is_placed("parent2"));
        $this->assertEquals(3, $grid->get_pos_x("parent2"));
        $this->assertEquals(1, $grid->get_pos_y("parent2"));
        
    }
    
    

    function test_diamond(){
        $parent = new class_("parent");
        $parent2 = new class_("parent2");
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child1->set_extends("parent");
        $child1->set_extends("parent2");
        $child2->set_extends("parent");
        $child2->set_extends("parent2");
        
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        $grid->add_element( $parent2 );
        
        $grid->distribute();
        
        //         var_dump($grid->get_classes());
        
        $this->assertEquals(4, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(1, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child1"));
        $this->assertEquals(1, $grid->get_pos_x("child1"));
        $this->assertEquals(2, $grid->get_pos_y("child1"));
        
        $this->assertEquals( true, $grid->is_placed("child2"));
        $this->assertEquals(2, $grid->get_pos_x("child2"));
        $this->assertEquals(2, $grid->get_pos_y("child2"));
        
        $this->assertEquals( true, $grid->is_placed("parent2"));
        $this->assertEquals(3, $grid->get_pos_x("parent2"));
        $this->assertEquals(1, $grid->get_pos_y("parent2"));
    }
    
    
    
}

