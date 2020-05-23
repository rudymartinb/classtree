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
        $this->type = $this->extract_mod( $source );
        $this->name = $this->extract_name($source);
    }
    
    private function extract_mod( string $source ){
        $source = trim( $source );
        $pos = strpos($source, "$");
        
        // dollar sign must be present
        if( $pos === FALSE or $pos == 0){
            return "";
        }
        return substr($source,0, $pos-1);
        
    }
    
    private function extract_name( string $source ){
        $pos = strpos($source, "$");
        
        // dollar sign must be present
        if( $pos === FALSE ){
            return "";
        }
        return substr($source,$pos);
    }
    
}


// I call it "function" but it should be read as class method.
// (keyword "function" is used by PHP, not my fault)
class function_ {
    function __construct( string $source  ){
        $matches = $this->extract_functions($source);
        if( count( $matches ) > 0 ){
            $this->mod = $matches["fnmod"][0];
            $this->name = $matches["fnname"][0];
            $this->set_params( $matches["fnparams"][0] );
            $this->rettype= $matches["fnret"][0];
        }
    }
    private $mod; // pr
    function set_mod( string $mod ){
        $this->mod = $mod;
    }
    function get_mod() : string {
        return $this->mod;
    }
    
    private $name;
    function set_name( string $name ){
        $this->name = $name;
    }
    function get_name() : string {
        return $this->name;
    }
    
    private $params;
    function set_params( string $params ){
        $arrParams = explode(",", $params);
        foreach( $arrParams as $key => $value ){
            /* dolar sign indicates where the variable part starts
             */
            $param = new parameter_($value);
            $arrParams[ $key ] = $param;
        }
        $this->params = $arrParams;
    }
    function get_params() : Array {
        return $this->params;
    }
    
    private $rettype;
    
    function extract_functions( string $source ) : Array {
        $pattern  = "/^";
        $pattern .= "(";
        $pattern .= "(?:[ ]*)";
        $pattern .= "(?<fnmod>(static|private|public|final|))";
        $pattern .= "(?:[ ]*)";
        $pattern .= "(?<fntag>function)";
        $pattern .= "(?:[ ]*)";
        $pattern .= "(?<fnname>[0-9a-zA-Z_]+)[ ]*\(";
        $pattern .= "(?<fnparams>[0-9a-zA-Z_\$ ,]*|)[ ]*\)";
        $pattern .= "(?<fnret>[ ]*\:[ ]*[0-9a-zA-Z_]*[ ]*|)";
        $pattern .= ")";
        $pattern .= "/m";
        
        $finder = new class_finder();
        $finder->set_pattern($pattern);
        $matches = $finder->matches( $source );
        return $matches;
    }
    
    
}
