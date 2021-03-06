<?php
namespace src;

/* production code
 * should execute namespace_finder on each source
 * from there, get the source for each namespace containted among them 
 * (without namespace clauses)
 * then use this class passing both source and namespace name to it
 * 
 * if the source has no namespace, only source is needed.
 * 
 */
class class_finder {
	use finder;
	use finder_functions;
	
    private $namespace = "";
    
    function __construct( string $source, string $namespace = "" ){
    	$this->namespace = $namespace;
    	
        $this->pattern  = "/^\s*(?<original>";
        $this->pattern .= "(";
        
        // the extra enclosed subpattern 
        // is necesary to avoid including the trailing space
        $this->pattern .= "((?<final>final)\s*)*";
        $this->pattern .= "((?<abstract>abstract)\s*)*";
        
        $this->pattern .= "(?:class\s*)";
        $this->pattern .= "(?<classname>[0-9a-zA-Z_]+)";

        // extends always goes before implements
        $this->pattern .= "(\s*extends\s*(?<extends>[0-9a-zA-Z_]*))*";
        $this->pattern .= "(\s*implements\s*(?<implements>(\s*[0-9a-zA-Z_,]+)+))*";
        
        // end of the declaration line
        $this->pattern .= "[^{]*)";
        $this->pattern .= ")";
        
        // TODO: probably the correct way would be to search for nested {}
        // update: I have created a regex pattern which allows to extract them
        $this->pattern .= "(?<body>";
        $this->pattern .= "((?!(?R)).)*";
        $this->pattern .= ")";
       
        
        $this->pattern .= "/ms";
        
        $this->matches($source);
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
    function get_abstract() : string {
    	return $this->matches["abstract"][ $this->current_key ];
    }
    
    function get_final() : string {
    	return $this->matches["final"][ $this->current_key ];
    }
    function get_namespace() : string {
    	return $this->namespace;
    }
    
    function get_body() : string {
    	return $this->matches["body"][ $this->current_key ];
    }
  
    
    // use traits
    private $usetrait_finder;
    function more_traits() : bool {
    	if( $this->usetrait_finder === null ){
    		$body = $this->get_body();
    		$this->usetrait_finder = new usetrait_finder($body);
    	}
    	
    	return $this->usetrait_finder->more_elements();
    }
    function get_trait_name() : string {
    	return $this->usetrait_finder->get_trait_name();
    }
    function next_trait(){
    	return $this->usetrait_finder->next();
    }
    
    
}
