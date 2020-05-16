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
    function set_extends( string $name ){
        $this->extends[] = $name;
        $this->extends_resolved = false;
    }
    function get_extends() : Array {
        return $this->extends;
    }
    
    private $namespace;
    function set_namespace( string $nombre ){
        $this->namespace = $nombre;
    }
    function get_namespace() : string {
        return $this->namespace;
    }
    
    
    private $extends_resolved = true; 
    function is_extends_resolved() : bool {
        return $this->extends_resolved; 
    }
    
    private $extends_list;
    function resolve_extends( Array & $interfaces_list ){
        $this->extends_list = [];
        $this->extends_resolved = false;
        foreach ($this->extends as $interface ){
            foreach ($interfaces_list as $key => $interface_item ){
                if( $interface === $interface_item->get_name() ) {
                    $this->extends_list[ $interface ] = $interfaces_list[ $key ];
                    break;
                }
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