<?php
namespace nodes;

use src\clase;

abstract class node {
    abstract function set_parent( node $nodo );
    abstract function set_child( node $nodo );
    abstract function get_level() : int;
}



class node_clase extends node {
    
    private $clases = [];
    function set_clase( clase &$clase ){
        $this->clases[] = $clase;
    }
    
    private $parents = [];
    function set_parent( node $parent ){
        $nivelparent = $parent->get_level();
        if( $nivelparent >= $this->nivel ){
            $this->nivel = $nivelparent + 1; // HACK?
        }
        $this->parents[] = $parent;
        $parent->set_child( $this );
    }
    function get_num_parents() : int {
        return count( $this->parents );
    }
    function get_first_parent() : node {
        return $this->parents[0];
    }
    
    private $childs = [];
    function set_child( node $son ){
        $this->childs[] = $son;
    }
    function get_first_child() : node {
        return $this->childs[0];
    }
    
    
    private $nivel = 1;
    function get_level() : int {
        return $this->nivel;
    }
    
    
}
