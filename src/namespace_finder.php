<?php

namespace src;

class namespace_finder {
	
    private $pattern;
    private $source = "";
    function __construct( string $source ){
    	$this->source = $source;

    	/* for the namespace keyword 
    	 * then add all the code up to the next keyword.
    	 * 
    	 * TODO: test this against a windows newline character file 
    	 */
        $this->pattern  = "/^";
        $this->pattern .= "(?<original>[ ]*(?:namespace)[ ]+";
        $this->pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]+)";
        $this->pattern .= "(?:[^\n]*)";
        $this->pattern .= ")";
        /* rest of the namespace body is included
         * by doing a recursive negative search to find the rest
         */
        $this->pattern .= "(?<body>";
        $this->pattern .= "((?!(?R)).)*";
        $this->pattern .= ")";
        
        $this->pattern .= "/mxs";
        
        $this->matches($source);
    }

    /*
     * understanding $matches firt index key:
     * 0 = represents the lines of code matched
     * 1/nsname = name of the namespace found.
     * original = first line of code of the namespace matched
     *  
     */
    private $current_key = 0;
    function next(){
    	$this->current_key ++;
    }
    private $matches = [];
    function more_elements() : bool {
    	return count( $this->matches[ 0 ] ) > $this->current_key;
    }
    
    function get_name() : string {
    	return $this->matches["nsname"][ $this->current_key ];
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
    	
    	// TODO: REMOVE !!!
//     	$code = $this->matches["0"][$this->current_key];
//     	$original = $this->matches["original"][$this->current_key];
//     	$start = strlen( $original );
//     	return substr( $code, $start );
    }
   
    
}
