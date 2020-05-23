<?php
namespace src;

// I call it "function" but it should be read as class method.
// (keyword "function" is used by PHP, not my fault)
class function_ {
    private $mod; // pr
    function set_mod( string $mod ){
        $this->mod = $mod;
    }
    function get_mod() : string {
        return $this->mod;
    }
    
    private $name;
    function set_name( string $name ){
        $this->name = $name;
    }
    function get_name() : string {
        return $this->name;
    }
    
    private $params;
    function set_params( string $params ){
        $this->params = $params;
    }
    function get_params() : Array {
        return $this->params;
    }
    
    private $rettype;
    
}
