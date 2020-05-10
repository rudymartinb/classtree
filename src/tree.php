<?php
namespace nodes;

/*
 * my first attempt to develop a binary tree was to not use a container class for all nodes
 * that ended in walking all the tree to get the first element.
 * 
 * in this particular case we might have totally isolated classes
 * so I need to be able to have them all at hand to process them
 */
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