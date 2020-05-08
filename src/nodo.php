<?php

abstract class nodo {
    abstract function set_parent( nodo $nodo );
    abstract function set_child( nodo $nodo );
}

class tree {
    private $lista = [];
    function add_nodo( nodo &$nodo ){
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

class nodo_clase extends nodo {
//     function __construct(){
//         global $cant;
//         $cant += 1;
//         var_dump($cant);
//     }
    
    private $clases = [];
    function set_clase( \clase &$clase ){
        $this->clases[] = $clase;
    }
    
    private $parents = [];
    function set_parent( nodo $parent ){
        $nivelparent = $parent->get_nivel();
        if( $nivelparent >= $this->nivel ){
            $this->nivel = $nivelparent + 1; // HACK
        }
        $this->parents[] = $parent;
        $parent->set_child( $this );
    }
    function get_num_parents() : int {
        return count( $this->parents );
    }
    function get_first_parent() : nodo {
        return $this->parents[0];
    }
    
    private $childs = [];
    function set_child( nodo $son ){
        $this->childs[] = $son;
    }
    function get_first_child() : nodo {
        return $this->childs[0];
    }
    
    
    private $nivel = 1;
    function get_nivel() : int {
        return $this->nivel;
    }
    
    
}
