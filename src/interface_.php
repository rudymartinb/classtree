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
    
    private $extends_list;
    function resolve_extends( Array & $interfaces_list ){
        if( count( $this->get_extends() ) === 0 ){
            $this->extends_resolved = true;
            return ;
        }
        $this->extends_list = [];
        $this->extends_resolved = false;
        foreach ($this->extends as $interface ){
            $found_key = array_search( $interface,  $interfaces_list );
            if( $found_key !== false ){
                $this->extends_list[ $interface ] = $interfaces_list[ $found_key ];
            }
        }
        if( count( $this->extends_list ) === count( $this->extends ) ){
            $this->extends_resolved = true;
        }
            
        
    }
    
    // TODO: what about funcions inside an interface ?
    
}
function force_interface( $interface ) : interface_ {
    return $interface;
}