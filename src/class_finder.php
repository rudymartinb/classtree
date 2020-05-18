<?php
namespace src;

class class_finder {
    private $pattern;
    function __construct(){
        $this->pattern  = "/^(?<final>final|)(?<abstract>abstract|)[ ]*(?<tipo>class(?: ))[ ]*";
        $this->pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
        $this->pattern .= "(implements (?<implements>[0-9a-zA-Z_, ]*)|)[ ]+";
        $this->pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]*";
        $this->pattern .= "/m";
    }
    function set_patter( string $pattern ){
        $this->pattern = $pattern;
    }
    
    function matches( string $source ) : Array {
        $matches = [];
        preg_match_all($this->pattern, $source, $matches );
        return $matches;
    }
}