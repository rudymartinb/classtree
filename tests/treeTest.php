<?php

class treeTest extends PHPUnit\Framework\TestCase {
    
    function test_get_num_orphans_0() {
        $tree = new tree();
        $this->assertEquals( 0, $tree->get_num_orphans() );
    }
    
    /* builder
     */
    function crear_1nodo() : tree {
        $nodo = new nodo_clase();
        $nodo->set_clase( new clase("father") );
        
        $tree = new tree();
        $tree->add_nodo( $nodo );
        return $tree;
    }
    
    function test_nodo_clase() {
        $tree = $this->crear_1nodo();
        $this->assertEquals( 1, $tree->get_num_nodes() );
    }
    
    function crear_2nodos() : tree {
        $nodo = new nodo_clase();
        $nodo->set_clase( new clase("father") );
        
        $tree = new tree();
        $tree->add_nodo( $nodo );
        
        $nodo = new nodo_clase();
        $nodo->set_clase( new clase("mother") );
        $tree->add_nodo( $nodo );
        return $tree;
    }
    
    function test_get_num_nodes_2clases() {
        $tree = $this->crear_2nodos();
        
        $this->assertEquals( 2, $tree->get_num_nodes() );
    }
    
       
}

