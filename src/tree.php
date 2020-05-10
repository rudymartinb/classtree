<?php
namespace nodes;

/*
 * my first attempt to develop a binary tree was to not use a container class for all nodes
 * that ended in walking all the tree to get the top element.
 * 
 * in this particular case we might have totally isolated classes from each other
 * so I need to be able to have them all at hand to process them
 */
class tree {
    private $nodelist = [];
    function add_node( node &$nodo ){
        $this->nodelist[] = & $nodo;
    }
    
    function get_num_nodes() : int {
        return count( $this->nodelist );
    }
    
    
    function get_num_orphans() : int {
        $orphans = 0;
        foreach ($this->nodelist as $nodo ) {
            if( $nodo->get_num_parents() == 0 ){
                $orphans ++;
            }
        }
        return $orphans;
    }
    
}