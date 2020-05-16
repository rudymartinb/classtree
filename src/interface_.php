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
    function resolve_extends( Array $interfaces_list ){
        if( count( $this->get_extends() ) === 0 ){
            $this->extends_resolved = true;
            return ;
        }
        foreach ($interfaces_list as $interface ){
            $interface = force_interface($interface);
            $found_key = array_search( $interface->get_name() ,  $interface->get_extends() );
            if( $found_key === false ){
                continue;
            }
            
            
        }
    }
    
    // TODO: what about funcions inside an interface ?
    
}
function force_interface( $interface ) : interface_ {
    return $interface;
}