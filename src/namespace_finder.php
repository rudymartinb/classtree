<?php

namespace src;

class namespace_finder {
	
    private $pattern;
    private $source = "";
    function __construct( string $source ){
    	$this->source = $source;
    	
        $this->pattern  = "/^[ ]*(?:namespace)[ ]+";
        $this->pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]+)";
        $this->pattern .= "([ ;{]*)";
//         $this->pattern .= "(?<body>(?!(?0))*)";
        $this->pattern .= "(?<body>.*)";
        $this->pattern .= "/m";
        
        $this->matches($source);
    }

    /*
     * understanding $matches firt index key:
     * 0 = represents the lines of code matched
     * 1/nombretipo = name of the namespace found.
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
    	$source = $this->source;
    	
    	$start_position = $this->get_start_position($this->current_key);
    	
    	$body_lenght = strlen( $source )-$start_position;
    	
    	$next_line = $this->get_next_namepace_line();
    	
    	if( $next_line != "" and $next_line !== null ){
    		$newline_position = strpos( $source, $next_line )+1;
    		$body_lenght = $body_lenght - $newline_position ;
    	}
    	
    	return substr($this->source, $start_position, $body_lenght );
    }
    
    function get_start_position( int $key ) : string {
    	$line = $this->matches[0][$key];
    	
    	$start_position = strpos( $this->source , $line )+strlen( $line );
    	return $start_position;
    }
    
    function get_next_namepace_line() : string {
    	$line = $this->matches[0][$this->current_key+1];
    	if( $line === null ){
    		return "";
    	}
    	return $line;
    }
    
//     function find_bodies() : Array {
//     	return [];
//     }
    
//     function get_body( string $namespace, string $next_line = "" ) : string {
//     	$source = $this->source;
//     	$subkey = array_search( $namespace,  $this->matches["nombretipo"] );
//     	// line found
//     	$line = $this->matches[0][$subkey];

//     	$strpos1 = strpos( $source , $line )+strlen( $line )+1;
//     	$lenght = strlen( $source )-$strpos1;
//     	if( $next_line != "" ){
//     		$lenght = $lenght - strpos( $source, $next_line );
//     	} 

//     	return substr($this->source, $strpos1, $lenght );
//     }
    
//     function split() : Array {
//     	if( !$this->found() ){
//     		return [];
//     	}
//     	$nslist = [];
//     	foreach ($this->matches["nombretipo"] as $key => $namespace ){
//     		$next_line = $this->matches[ 0 ][$key+1];
//     		if( $next_line === null ){
//     			$next_line = "";
//     		} 
//     		$nslist[] = [ "namespace" => $namespace, "body" => $this->get_body($namespace, $next_line) ];
//     	}
    	
//     	return $nslist;
//     }
//     function found() : bool {
//     	return count( $this->matches[0] ) != 0;
//     }
    
}
