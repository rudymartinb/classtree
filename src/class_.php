<?php
namespace src;

/*
 * purpose:
 * 
 * hold the information on each class and interfaces nodes 
 * 
 */

class class_ {
    
    private $name;
    function __construct( string $name ){
        $this->name = $name;
        $this->type = "class";
    }
    function get_name() : string {
        return $this->name;
    }
    
    private $type = "";
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
    
    private $extends = [];
    function get_extends() : Array {
        return $this->extends;
    }
    function set_extends( string $parent ){
        $this->extends[] = $parent;
    }
    
    function is_child_of( string $parent ) : bool {
        return 
        array_search( $parent, $this->extends, true ) !== FALSE or
        array_search( $parent, $this->implements, true ) !== FALSE;
    }
    function is_child() : bool {
        return count( $this->extends ) != 0 or count( $this->implements ) != 0;
    }

    private $implements = [];
    function get_implements(){
        return $this->implements;
    }
    function set_implements( string $extends ){
        $array = explode( "," , $extends );
        foreach( $array as $key => $extend ){
            $array[ $key ] = trim( $extend );
        }
        $this->implements = $array;
    }
    
    

    
    private $namespace = "";
    function set_namespace( string $nombre ){
        $this->namespace = $nombre;
    }
    function get_namespace() : string {
        return $this->namespace;
    }
    
    private $functions = [];
    function set_function( string $nombre, Array $parameters, string $return = "" ){
        $this->functions[] = [ $nombre, $parameters, $return ];
    }
    function get_functions() : Array {
        return $this->functions;
    }
    

    
}

// fool IDE into use the propper type for autocompletion.
function force_class( $class ) : class_ {
    return $class;
}

