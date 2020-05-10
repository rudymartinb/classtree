<?php

class nodosTest extends PHPUnit\Framework\TestCase {
    


    function build_parent_child() : tree {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("son") );
        $tree->add_nodo( $nodo2 );
        
        $nodo2->set_parent( $nodo1 );
        
        $tree->set_parent( $nodo1, $nodo2 );
        
        return $tree;
    }
    
    function test_nodo_2clases_2() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("son") );
        $tree->add_nodo( $nodo2 );
        
        $nodo2->set_parent( $nodo1 );
        
        $this->assertEquals( 1, $nodo2->get_num_parents() );
        $nodotest = $nodo2->get_first_parent();
        
        $this->assertEquals( true, $nodotest === $nodo1 );
        
        $nodotest = $nodo1->get_first_child();
        $this->assertEquals( true, $nodotest === $nodo2 );
    }

    function build_2parents_1child() : tree {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("mother") );
        $tree->add_nodo( $nodo2 );
        
        $nodo3 = new nodo_clase();
        $nodo3->set_clase( new clase("son") );
        
        $tree->add_nodo( $nodo3 );
        
        $tree->set_parent( $nodo1, $nodo3 );
        $tree->set_parent( $nodo2, $nodo3 );
        return $tree;
    }
    
//     function test_nodo_3clases_2padres() {
//         $tree = $this->build_2parents_1child();
//         var_dump( $tree );
//         $this->assertEquals( 2, $tree->get_num_orphans() );
//     }
    
    
    function test_tree_orphans_1() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $this->assertEquals( 1, $tree->get_num_orphans() );
    }

    function test_tree_orphans_1_de_2() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );

        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("son") );
        $nodo2->set_parent($nodo1);
        $tree->add_nodo( $nodo2 );
        
        
        $this->assertEquals( 1, $tree->get_num_orphans() );
    }
    
    function test_nivel1() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $this->assertEquals( 1, $nodo1->get_nivel() );
    }

    function test_nivel2() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );

        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("son") );
        $nodo2->set_parent($nodo1);
        $tree->add_nodo( $nodo2 );
        
        $this->assertEquals( 2, $nodo2->get_nivel() );
    }

    function test_nivel3() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("son") );
        $nodo2->set_parent($nodo1);
        $tree->add_nodo( $nodo2 );

        $nodo3 = new nodo_clase();
        $nodo3->set_clase( new clase("son") );
        $nodo3->set_parent($nodo2);
        $tree->add_nodo( $nodo3 );
        
        $this->assertEquals( 3, $nodo3->get_nivel() );
    }

    function test_nivel4() {
        $tree = new tree();
        
        $nodo1 = new nodo_clase();
        $nodo1->set_clase( new clase("father") );
        $tree->add_nodo( $nodo1 );
        
        $nodo2 = new nodo_clase();
        $nodo2->set_clase( new clase("son") );
        $nodo2->set_parent($nodo1);
        $tree->add_nodo( $nodo2 );
        
        $nodo3 = new nodo_clase();
        $nodo3->set_clase( new clase("son") );
        $nodo3->set_parent($nodo2);
        $tree->add_nodo( $nodo3 );

        $nodo4 = new nodo_clase();
        $nodo4->set_clase( new clase("son") );
        $nodo4->set_parent($nodo3);
        $tree->add_nodo( $nodo4 );

        $nodo41 = new nodo_clase();
        $nodo41->set_clase( new clase("son") );
        $tree->add_nodo( $nodo41 );
        
        $nodo5 = new nodo_clase();
        $nodo5->set_clase( new clase("son") );
        $nodo5->set_parent($nodo4);
        $nodo5->set_parent($nodo41);
        $tree->add_nodo( $nodo4 );
        
        $this->assertEquals( 1, $nodo41->get_nivel() );
        $this->assertEquals( 5, $nodo5->get_nivel() );
    }
    
    /*
     * now we want to set/check each node level based on the "tree"
     * 
     * A   X
     * |   |
     * B   |
     * |   |
     * C---|
     * |
     * D
     * 
     * in this example, 5! = 120 permutations are needed
     * to test if the production code behaves correctly
     */
    
    
}
