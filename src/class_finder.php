<?php
namespace src;

class class_finder {
    private $pattern;
    function __construct(){
        $this->pattern  = "/^(?<este>(";
        $this->pattern .= "[ ]*(?:namespace)[ ]*";
        $this->pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]+)[ ]*;";
        $this->pattern .= ")|(";
        $this->pattern .= "(?<final>final|)(?<abstract>abstract|)[ ]*(?<tipo>class(?: ))[ ]*";
        $this->pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
        $this->pattern .= "(implements (?<implements>[0-9a-zA-Z_, ]*)|)[ ]+";
        $this->pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]*";
        $this->pattern .= "))/m";
    }
    function set_patter( string $pattern ){
        $this->pattern = $pattern;
    }
    
    private $matches;
    function matches( string $source ) : Array {
        $matches = [];
        preg_match_all($this->pattern, $source, $matches );
        $this->matches = $matches;
        return $matches;
    }
    
    function separar_clases() : Array {
        $matches = $this->matches;
        $lista = [];
        $namespace = "";
        foreach ($matches["tipo"] as $key => $value ) {
            if( $matches[ "nsname" ][ $key ] != "" ){
                $namespace = $matches[ "nsname" ][ $key ];
                continue;
            }
            if( trim( $value ) != "class" ){
                continue;
            }
            
            $clase = new class_( trim( $matches[ "nombretipo"][$key] ) );
            $clase->set_extends( $matches["extends"][$key] );
            $clase->set_implements( $matches["implements"][$key] );
            $clase->set_abstract( $matches["abstract"][$key] );
            $clase->set_namespace( $namespace );
            
            $lista[] = $clase;
        }
        return $lista;
    }
    
}

class namespace_finder {
    private $pattern;
    function __construct(){
        $this->pattern  = "/^[ ]*(?<tipo>namespace)[ ]+";
        $this->pattern .= "(?<nombretipo>[0-9a-zA-Z_\\\\]+)[ ;]*";
        $this->pattern .= "/m";
    }
    function set_patter( string $pattern ){
        $this->pattern = $pattern;
    }
    
    function matches( string $source ) : Array {
        $matches = [];
        preg_match_all($this->pattern, $source, $matches );
        return $matches;
    }
}