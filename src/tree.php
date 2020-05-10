<?php
namespace nodes;
class tree {
    private $lista = [];
    function add_node( node &$nodo ){
        $this->lista[] = & $nodo;
    }
    
    function get_num_nodes() : int {
        return count( $this->lista );
    }
    
    
    function get_num_orphans() : int {
        $orphans = 0;
        foreach ($this->lista as $nodo ) {
            if( $nodo->get_num_parents() == 0 ){
                $orphans ++;
            }
        }
        return $orphans;
    }
    
}