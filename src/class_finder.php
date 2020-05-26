<?php
namespace src;

class class_finder {
    private $pattern;
    
    private $matches;
    private $source = "";
    
    function __construct( string $source ){
        $this->pattern  = "/^(?<original>";
        $this->pattern .= "(";
        $this->pattern .= "(?<final>final |)";
        $this->pattern .= "(?<abstract>abstract |)";
        $this->pattern .= "(?:class)(?: )[ ]*";
        $this->pattern .= "(?<classname>[0-9a-zA-Z_]+)";
        
        // I'm not sure which one can precede the other
        $this->pattern .= "(";
        $this->pattern .= "( extends (?<extends>[0-9a-zA-Z_]*))|";
        $this->pattern .= "( implements (?<implements>(\s*[0-9a-zA-Z_,]*)*))";
        $this->pattern .= ")*";
        $this->pattern .= "[^{]*)";
        $this->pattern .= "(?<body>";
        $this->pattern .= "((?!class).)*";
        $this->pattern .= ")";
        
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
    

        
//     function separar_clases() : Array {
//         $lista = [];
//         return $lista;
//     }
    
//     function extract_functions( string $source ) : Array {
//         $pattern  = "/^";
//         $pattern .= "(";
//         $pattern .= "(?:[ ]*)";
//         $pattern .= "(?<fnmod>(static|private|public|final|))";
//         $pattern .= "(?:[ ]*)";
//         $pattern .= "(?<fntag>function)";
//         $pattern .= "(?:[ ]*)";
//         $pattern .= "(?<fnname>[0-9a-zA-Z_]+)[ ]*\(";
//         $pattern .= "(?<fnparams>[0-9a-zA-Z_\$ ,]*|)[ ]*\)";
//         $pattern .= "(?<fnret>[ ]*\:[ ]*[0-9a-zA-Z_]*[ ]*|)";
//         $pattern .= ")";
//         $pattern .= "/m";
        
//         $finder = new class_finder();
//         $finder->set_pattern($pattern);
//         $matches = $finder->matches( $source );
//         return $matches;
//     }
    
    
}
