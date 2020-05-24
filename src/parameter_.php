<?php
namespace src;


class parameter_ {
    private $type;
    function get_type() : string {
        return $this->type;
    }
    
    private $name;
    function get_name() : string {
        return $this->name;
    }
    
    function __construct( string $source ){
        $this->type = $this->extract_type( $source );
        $this->name = $this->extract_name($source);
    }
    
    private function extract_type( string $source ){
        $source = trim( $source );
        $pos = strpos($source, "$");
        
        // dollar sign must be present
        if( $pos === FALSE or $pos == 0){
            return "";
        }
        return trim( substr($source,0, $pos-1) );
        
    }
    
    private function extract_name( string $source ){
        $pos = strpos($source, "$");
        
        // dollar sign must be present
        if( $pos === FALSE ){
            return "";
        }
        return trim( substr($source,$pos) );
    }
    
}
