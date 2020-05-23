<?php
namespace src;

class class_finder {
    private $pattern;
    function __construct(){
        $this->pattern  = "/^(?<este>";
        $this->pattern .= "([ ]*(?<nsflag>namespace)[ ]*";
        $this->pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]+)[ ]*;";
        $this->pattern .= ")|";
        $this->pattern .= "([ ]*(?<ifflag>interface)[ ]*";
        $this->pattern .= "(?<interface>[0-9a-zA-Z_]+)[ ]*{";
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
            if( $matches[ "nsflag" ][ $key ] == "namespace" ){
                $namespace = $matches[ "nsname" ][ $key ];
                continue;
            }
            if( $value == "class "){
                $clase = new class_( trim( $matches[ "nombretipo"][$key] ) );
                $clase->set_type( "class" );
                $clase->set_extends( $matches["extends"][$key] );
                $clase->set_implements( $matches["implements"][$key] );
                $clase->set_abstract( $matches["abstract"][$key] );
                $clase->set_namespace( $namespace );
                $lista[] = $clase;
                continue;
            }
            if( $matches[ "ifflag" ][ $key ] == "interface" ){
                $clase = new class_( trim( $matches[ "interface"][$key] ) );
                $clase->set_type( "interface" );
                $clase->set_extends( $matches["extends"][$key] );
                $clase->set_namespace( $namespace );
                $lista[] = $clase;
                continue;
            } 

                
            
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