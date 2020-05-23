<?php
namespace src;

/*
 * starting all over again.
 * 
 * goal:
 * 
 * establish beforehand where all the elements should be placed
 * 
 * since the Tree data has the information about height and width for each tree
 * all that is needed is to calculate how to distribute each item.
 * 
 * ok, lets think
 * 
 * my previous approach was to consider the left "column" of each tree
 * now I'm going to each "row", taking into account the width of each tree 
 * in order to distribute the items evenly
 * 
 * 
 */

class grid {

    private $tree;
    function add_tree( Tree $tree ){
        $this->tree = $tree;
    }
    function distribute(){
                
    } 
    function get_num_elements() : int {
        return 0;
    }
   
}