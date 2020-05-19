<?php
namespace src;



class class_ {
    
    private $name;
    function __construct( string $name ){
        $this->name = $name;
        $this->extends_class = null;
    }
    function get_name() : string {
        return $this->name;
    }
    
    private $type;
    function set_type( string $type ){
        $this->type = $type;
    }
    function get_type() : string {
        return $this->type;
    }
    
    private $abstract = "";
    function set_abstract( string $abstract ){
        $this->abstract = $abstract;
    }
    function get_abstract() : string{
        return $this->abstract;
    }
    private $final = "";
    function set_final( string $final ){
        $this->final = $final;
    }
    function get_final() : string {
        return $this->final;
    }
    
    private $extends = "";
    function get_extends() : string {
        return $this->extends;
    }
    function set_extends( string $nombre ){
        $this->extends = $nombre;
    }

    private $interface_extends;
    function get_interface_extends() : Array {
        return $this->interface_extends;
    }
    function set_interface_extends( string $extends ){
        $array = explode( "," , $extends );
        $this->interface_extends = $array;
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
    

    
}

// fool IDE into use the propper type for autocompletion.
function force_class( $mixed ) : class_ {
    return $mixed;
}

