<?php
namespace src;

interface class_interface {
    function is_null() : bool;
}



class class_ implements class_interface  {
    
    private $name;
    function __construct( string $name ){
        $this->name = $name;
        $this->extends_class = new class_null();
    }
    function get_name() : string {
        return $this->name;
    }
    
    private $extends = "";
    private $extends_resolved = true;
    function is_extends_resolved() : bool {
        return $this->extends_resolved;
    }
    function set_extends( string $nombre ){
        $this->extends_resolved = false;
        $this->extends = $nombre;
    }
    
    private $extends_class;
    function find_extends( Array & $classes ){
        if( $this->extends == "" ){
            $this->extends_resolved = true;
            return;
        }
        foreach ( $classes as $class ){
            $class = force_class( $class );
            if( $class->get_name() == $this->extends ){
                $this->extends_resolved = true;
                $this->extends_class = $class;
                return;
            }
        }
    }
    function get_extends_class() : class_interface {
        return $this->extends_class;
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

// fool IDE into use the propper type for autocompletion.
function force_class( $mixed ) : class_ {
    return $mixed;
}

/* null object pattern.
 * Needed to avoid using the NULL value
 * which could prevent us from set the return type of a function
 * 
 * and more importantly, by doing this we avoid nasty exceptions
 */
class class_null implements class_interface {
    function is_null() : bool {
        return true;
    }
    // TODO: do I have to implement other functions? lets hope not!
}
