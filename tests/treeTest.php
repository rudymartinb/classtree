<?php

use nodes\nodo_clase;
use nodes\tree;

class treeTest extends PHPUnit\Framework\TestCase {
    
    function test_get_num_orphans_0() {
        $tree = new tree();
        $this->assertEquals( 0, $tree->get_num_orphans() );
    }
    
    /* tree builder for these tests
     */
    function build_1node() : tree {
        $nodo = new nodo_clase();
        $nodo->set_clase( new clase("father") );
        
        $tree = new tree();
        $tree->add_node( $nodo );
        return $tree;
    }
    
    function build_2nodes() : tree {
        $nodo = new nodo_clase();
        $nodo->set_clase( new clase("father") );
        
        $tree = new tree();
        $tree->add_node( $nodo );
        
        $nodo = new nodo_clase();
        $nodo->set_clase( new clase("mother") );
        $tree->add_node( $nodo );
        return $tree;
    }
    
    
    function test_get_num_nodes_1() {
        $tree = $this->build_1node();
        $this->assertEquals( 1, $tree->get_num_nodes() );
    }
    
    function test_get_num_nodes_2() {
        $tree = $this->build_2nodes();
        
        $this->assertEquals( 2, $tree->get_num_nodes() );
    }
    
       
}

