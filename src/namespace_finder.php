<?php

namespace src;

class namespace_finder {
    private $pattern;
    
    // regex tags and array key for $matches 
    const nsname = "nsname";
    
    function __construct(){
        $this->pattern  = "/^[ ]*(?:namespace)[ ]+";
        $this->pattern .= "(?<nombretipo>[0-9a-zA-Z_\\\\]+)[ ;{]*";
        $this->pattern .= "/m";
    }
    function set_pattern( string $pattern ){
        $this->pattern = $pattern;
    }
    
    private $source = "";
    private $matches = [];
    function matches( string $source ) : Array {
    	$this->source = $source;
        $matches = [];
        preg_match_all($this->pattern, $source, $matches );
        $this->matches = $matches;
        return $matches;
    }
    function find_bodies() : Array {
    	return [];
    }
    function get_body( string $namespace, string $next_ns = "" ) : string {
    	$subkey = array_search( $namespace,  $this->matches["nombretipo"] );
    	// line found
    	$line = $this->matches[0][$subkey];

    	$strpos1 = strpos($this->source, $line )+strlen( $line )+1;
    	$lenght = strlen( $this->source )-$strpos1;
    	if( $next_ns != "" ){
    		$lenght = $lenght - strpos($this->source, $next_ns )+1;
    	} 
//     	var_dump( $strpos1 );
    	return substr($this->source, $strpos1, $lenght );
    }
    function split() : Array {
    	if( !$this->found() ){
    		return [];
    	}
    	$nslist = [];
    	foreach ($this->matches["nombretipo"] as $key => $namespace ){
    		$next_line = $this->matches[ 0 ][$key+1];
    		if( $next_line === null ){
    			$next_line = "";
    		} 
    		$nslist[] = [ "namespace" => $namespace, "body" => $this->get_body($namespace, $next_line) ];
    	}
    	
    	return $nslist;
    }
    function found() : bool {
    	return count( $this->matches[0] ) != 0;
    }
    
}
