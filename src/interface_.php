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
    }
    function get_extends() : Array {
        return $this->extends;
    }
    
}