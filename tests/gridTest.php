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
        
        $this->assertEquals(1, $grid->max_x() );
        $this->assertEquals(1, $grid->max_y() );
        
        $grid->distribute();
        
    }

    function test_2(){
        $parent1 = new class_("mother");
        $parent2 = new class_("father");
        
        $grid = new grid();
        $grid->add_element( $parent1 );
        $grid->add_element( $parent2 );
        
        $grid->distribute();
        
//         var_dump($grid->get_classes());
        
        $this->assertEquals(2, $grid->get_num_classes());
        
        $this->assertEquals( true, $grid->is_placed("mother"));
        $this->assertEquals(1, $grid->get_pos_x("mother"));
        $this->assertEquals(1, $grid->get_pos_y("mother"));
        
        $this->assertEquals( true, $grid->is_placed("father"));
        $this->assertEquals(2, $grid->get_pos_x("father"));
        $this->assertEquals(1, $grid->get_pos_y("father"));
        
        $this->assertEquals(2, $grid->max_x() );
        $this->assertEquals(1, $grid->max_y() );
        
        
        
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
        
//         $grid->draw();
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

    function test_offset (){
        /*
         * 0 = 0
         * 1 = 0
         * 2 = 0
         * 3 = 1
         * 4 = 1
         * 5 = 2
         * 6 = 2
         * 7 = 3
         * 8 = 3
         * 9 = 4
         */
        $grid = new grid();
        $this->assertEquals(0, $grid->offset(0 ));
        $this->assertEquals(0, $grid->offset(1 ));
        $this->assertEquals(0, $grid->offset(2 ));
        $this->assertEquals(1, $grid->offset(3 ));
        $this->assertEquals(1, $grid->offset(4 ));
        $this->assertEquals(2, $grid->offset(5 ));
        $this->assertEquals(2, $grid->offset(6 ));
        $this->assertEquals(3, $grid->offset(7 ));
        $this->assertEquals(3, $grid->offset(8 ));
        $this->assertEquals(4, $grid->offset(9 ));
        $this->assertEquals(4, $grid->offset(10 ));
        
    }
    
    function test_1parent3_parent_centered(){
        $parent = new class_("parent");
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child3 = new class_("child3");
        
        $child1->set_extends("parent");
        $child2->set_extends("parent");
        $child3->set_extends("parent");
                
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        $grid->add_element( $child3 );

        
        $grid->distribute();
        $grid->center_parents();
        
//         $grid->draw();
//                 var_dump($grid->get_classes());
        
        $this->assertEquals(4, $grid->get_num_classes());
        
        $this->assertEquals(3, $grid->get_num_children("parent"));
        
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(2, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child1"));
        $this->assertEquals(1, $grid->get_pos_x("child1"));
        $this->assertEquals(2, $grid->get_pos_y("child1"));
        
        $this->assertEquals( true, $grid->is_placed("child2"));
        $this->assertEquals(2, $grid->get_pos_x("child2"));
        $this->assertEquals(2, $grid->get_pos_y("child2"));
        
        $this->assertEquals( true, $grid->is_placed("child3"));
        $this->assertEquals(3, $grid->get_pos_x("child3"));
        $this->assertEquals(2, $grid->get_pos_y("child3"));
        
//         $grid->draw();
    }
    
    
    /// /////////// 

    function test_2parents2children(){
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

    function test_tree_1(){
        $parent = new class_("parent");
        
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child3 = new class_("child3");
        
        $child1->set_extends("parent");
        $child2->set_extends("parent");
        $child3->set_extends("child1");
        
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        $grid->add_element( $child3 );
        
        $grid->distribute();
        
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
        
        $this->assertEquals( true, $grid->is_placed("child3"));
        $this->assertEquals(1, $grid->get_pos_x("child3"));
        $this->assertEquals(3, $grid->get_pos_y("child3"));
        
        
    }

    function test_tree_2(){
        $parent = new class_("parent");
        
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child3 = new class_("child3");
        $child4 = new class_("child4");
        
        $child1->set_extends("parent");
        $child2->set_extends("parent");
        $child3->set_extends("child1");
        $child4->set_extends("child1");
        
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        $grid->add_element( $child3 );
        $grid->add_element( $child4 );
        
        $grid->distribute();
        
        $this->assertEquals(5, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(1, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child1"));
        $this->assertEquals(1, $grid->get_pos_x("child1"));
        $this->assertEquals(2, $grid->get_pos_y("child1"));
        
        $this->assertEquals( true, $grid->is_placed("child2"));
        $this->assertEquals(2, $grid->get_pos_x("child2"));
        $this->assertEquals(2, $grid->get_pos_y("child2"));
        
        $this->assertEquals( true, $grid->is_placed("child3"));
        $this->assertEquals(1, $grid->get_pos_x("child3"));
        $this->assertEquals(3, $grid->get_pos_y("child3"));

        $this->assertEquals( true, $grid->is_placed("child4"));
        $this->assertEquals(2, $grid->get_pos_x("child4"));
        $this->assertEquals(3, $grid->get_pos_y("child4"));
        
//         $grid->draw();
        
//         $grid->draw();
        
    }

    function test_1_parent_4_children(){
        $parent = new class_("parent");
        
        $child1 = new class_("child1");
        $child2 = new class_("child2");
        $child3 = new class_("child3");
        $child4 = new class_("child4");
        
        $child1->set_extends("parent");
        $child2->set_extends("parent");
        $child3->set_extends("parent");
        $child4->set_extends("parent");
        
        $grid = new grid();
        $grid->add_element( $parent );
        $grid->add_element( $child1 );
        $grid->add_element( $child2 );
        $grid->add_element( $child3 );
        $grid->add_element( $child4 );
        
        $grid->distribute();
        $grid->center_parents();
        
        $this->assertEquals(5, $grid->get_num_classes());
        $this->assertEquals( true, $grid->is_placed("parent"));
        $this->assertEquals(2, $grid->get_pos_x("parent"));
        $this->assertEquals(1, $grid->get_pos_y("parent"));
        
        $this->assertEquals( true, $grid->is_placed("child1"));
        $this->assertEquals(1, $grid->get_pos_x("child1"));
        $this->assertEquals(2, $grid->get_pos_y("child1"));
        
        $this->assertEquals( true, $grid->is_placed("child2"));
        $this->assertEquals(2, $grid->get_pos_x("child2"));
        $this->assertEquals(2, $grid->get_pos_y("child2"));
                
        $grid->draw();
        
    }
    
//     function test100() {
//         $grid = new grid();
        
        
//         $classes = [];
//         for( $i=1; $i <= 10; $i++){
//             $class = new class_("parent".$i);
//             $classes[] = $class ;
//             for( $j=1; $j <= 10; $j++){
//                 $class = new class_("son".$i."_".$j);
//                 $class->set_extends("parent".$i);
//                 $classes[] = $class ;
//                 $grid->add_element( $class );
//             }
            
//         }
        
//         $grid->distribute();
//         $grid->center_parents();
//         var_dump( $grid );
// //         var_dump( $grid->max_y() );
        
//         $grid->draw();
        
        
//         $this->assertEquals(100, $grid->get_num_classes());
        
//     }
    
    
}

