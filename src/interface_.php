<?php
namespace src;

class interface_ {
    private $name;
    function __construct( string $name ) {
        $this->name = $name;
    }
    
    function get_name() : string {
        return $this->name;
    }
    
    private $extends = [];
    function add_extends( string $name ){
        $this->extends[] = $name;
        $this->extends_resolved = false;
    }
    function get_extends() : Array {
        return $this->extends;
    }
    
    private $extends_resolved = true; 
    function is_extends_resolved() : bool {
        return $this->extends_resolved; 
    }
    function resolve_extends( Array $extends_list ){
        foreach ($extends_list as $extends ){
            
        }
    }
    
    // TODO: what about funcions inside an interface ?
    
}
function force_interface( $interface ) : interface_ {
    return $interface;
}