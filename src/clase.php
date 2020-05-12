<?php
namespace src;


// since "class" is a reserved word in PHP 
// I have no choice but to use the spanish one
interface clase_interface {
    function get_name();
    function set_extends( string $nombre );
    function get_extends() : string;
    function set_implements( string $nombre );
    function get_implements();
    function set_namespace( string $nombre );
    function get_namespace() : string;
    function set_funcion( string $nombre, Array $parameters, string $return = "" );
    function get_funciones() : Array ;
    function is_null() : bool;
    function is_parent_resolved() : bool;
}


class clase implements clase_interface {
    
    private $name;
    function __construct( string $name ){
        $this->name = $name;
    }
    function get_name() : string {
        return $this->name;
    }
    
    // mark this class as NOT resolved
    private $resolved = true;
    function is_parent_resolved() : bool {
        return $this->resolved;
    }
    
    private $extends = "";
    private $parent_resolved = true;
    function set_extends( string $nombre ){
        $this->resolved = false;
        $this->parent_resolved = false;
        $this->extends = $nombre;
    }
    function get_parent( Array $classes ){
        $this->parent_resolved = true;
        $this->resolved = true;
    }
    
    function get_extends() : string {
        return $this->extends;
    }
    
    private $implements = [];
    function set_implements( string $nombre ){
        $this->resolved = false;
        $this->implements[] = $nombre;
    }
    function get_implements(){
        return $this->implements;
    }
    
    private $namespace = "";
    function set_namespace( string $nombre ){
        $this->namespace = $nombre;
    }
    function get_namespace() : string {
        return $this->namespace;
    }
    
    private $funciones = [];
    function set_funcion( string $nombre, Array $parameters, string $return = "" ){
        $this->funciones[] = [ $nombre, $parameters, $return ];
    }
    function get_funciones() : Array {
        return $this->funciones;
    }
    
    function is_null() : bool {
        return false;
    }
    
    
}

/* null object pattern. 
 * Needed to avoid using the NULL value
 * which prevent us to set the return type of a function
 */
class clase_null extends clase {
    function is_null() : bool {
        return true;
    }
}

// fool IDE into use the propper type for autocompletion.
function force_class( $mixed ) : clase {
    return $mixed;
}
