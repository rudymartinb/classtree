<?php

namespace src;

class namespace_finder {
	use finder;
	
    function __construct( string $source ){
    	$this->source = $source;

    	/* for the namespace keyword 
    	 * then add all the code up to the next keyword.
    	 * 
    	 * TODO: test this against a windows newline character file 
    	 */
        $this->pattern  = "/^";
        $this->pattern .= "(?<original>[ ]*(?:namespace )";
        $this->pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]*)";
        
        // everything else up to the character that ends the namespace declaration
        // the objective here is to include the semicolon if present
        // but exclude the brace if present.
        // its either one of them, can't be none or both.
        $this->pattern .= "(?:([\s;]*)|([^{]*))"; 
        $this->pattern .= ")";
        
        /* rest of the namespace body is included
         * by doing a negative recursive search
         * (IOW: just the code that follows up to the next namespace, 
         * that's what I call "body")
         * 
         * will include everything previously excluded in the first part 
         */
        $this->pattern .= "(?<body>";
        $this->pattern .= "((?!(?R)).)*";
        $this->pattern .= ")";
        
        $this->pattern .= "/ms";
        
        $this->matches($source);
    }

    /*
     * in this particular case,
     * we might have no namespace tag on a source file.
     * name should be "" and 
     * by calling get_body we will get
     */
    function more() : bool {
    	if( $this->current_key == 0 and 
    			count( $this->matches[ 0 ] ) == 0 )
    		return true;
    	return count( $this->matches[ 0 ] ) > $this->current_key;
    }
    
    function get_name() : string {
    	if( $this->more() and 
    			$this->matches["nsname"][ $this->current_key ] == null ){
    		return "";
    	}
    	return $this->matches["nsname"][ $this->current_key ];
    }
    
    function get_body() : string {
    	if( $this->more() and 
    			$this->matches["body"][ $this->current_key ] === null ){
    		return $this->source;
    	}
    	return $this->matches["body"][ $this->current_key ];
    }
   
    
}

