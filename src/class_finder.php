<?php
namespace src;

class class_finder {
    private $pattern;
    
    private $matches;
    private $source = "";
    
    function __construct( string $source ){
        $this->pattern  = "/^(?<original>";
        $this->pattern .= "(";
        $this->pattern .= "(?<final>final )*";
        $this->pattern .= "(?<abstract>abstract )*";
        $this->pattern .= "(?:class)(?: )[ ]*";
        $this->pattern .= "(?<classname>[0-9a-zA-Z_]+)+";

        // extends always goes before implements
//         $this->pattern .= "(";
        $this->pattern .= "( extends (?<extends>[0-9a-zA-Z_]*))*";
        $this->pattern .= "( implements (?<implements>(\s*[0-9a-zA-Z_,]+)+))*";
//         $this->pattern .= ")*";
        $this->pattern .= "[^{]*)";
        $this->pattern .= ")";
        $this->pattern .= "(?<body>";
        
        // TODO: probably the correct way would be to search for nested {}
        $this->pattern .= "((?!((?R)|interface )).)*";
        $this->pattern .= ")";
        
        // body business
        
        $this->pattern .= "/ms";
        
        $this->matches($source);
    }
    
    private $current_key = 0;
    function next(){
    	$this->current_key ++;
    }
    function more_elements() : bool {
    	return count( $this->matches[ 0 ] ) > $this->current_key;
    }
    
    function get_name() : string {
    	return $this->matches["classname"][ $this->current_key ];
    }
    function get_extends() : string {
    	return $this->matches["extends"][ $this->current_key ];
    }
    function get_implements() : string {
    	return $this->matches["implements"][ $this->current_key ];
    }
    

    function matches( string $source ) : Array {
    	$this->source = $source;
    	$matches = [];
    	preg_match_all($this->pattern, $source, $matches );
    	$this->matches = $matches;
    	return $matches;
    }
    
    function get_body() : string {
    	return $this->matches["body"][ $this->current_key ];
    }
  
    
    
}
