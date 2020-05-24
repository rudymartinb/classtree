<?php

namespace sarasa;
function sarasa(){
	
}

namespace src;

class namespace_finder {
    private $pattern;
    function __construct(){
        $this->pattern  = "/^[ ]*(?:namespace)[ ]+";
        $this->pattern .= "(?<nombretipo>[0-9a-zA-Z_\\\\]+)[ ;{]*";
        $this->pattern .= "/m";
    }
    function set_patter( string $pattern ){
        $this->pattern = $pattern;
    }
    
    private $source = "";
    private $matches = [];
    function matches( string $source ) : Array {
        $matches = [];
        preg_match_all($this->pattern, $source, $matches );
        $this->matches = $matches;
        return $matches;
    }
    function find_bodies() : Array {
    	return [];
    }
    function split() : Array {
    	if( !$this->found() ){
    		return [];
    	}
    	$nslist = [];
    	foreach ($this->matches["nombretipo"] as $namespace ){
    		$nslist[] = [ "namespace" => $namespace ];
    	}
    	
    	return $nslist;
    }
    function found() : bool {
    	return count( $this->matches[0] ) != 0;
    }
    
}
