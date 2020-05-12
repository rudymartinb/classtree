<?php

// since "class" is a reserved word in PHP 
// I have no choice but to use the spanish one
class clase {
    private $name;
    
    function __construct( string $name ){
        $this->name = $name;
    }
    function get_name() : string {
        return $this->name;
    }
    
    private $extends = "";
    function set_extends( string $nombre ){
        $this->extends = $nombre;
    }
    function get_extends() : string {
        return $this->extends;
    }
    
    private $implements = [];
    function set_implements( string $nombre ){
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