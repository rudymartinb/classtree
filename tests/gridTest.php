<?php

use src\grid;
use src\class_;

class gridTest extends PHPUnit\Framework\TestCase {
    
    function test_1(){
        $class1 = new class_("class1");
//         $class2 = new class_("class2");
        
        $grid = new grid();
        $grid->add_element( $class1 );
        
        $this->assertEquals(1, $grid->get_rows());
        $this->assertEquals(1, $grid->get_columns());
    }
}

