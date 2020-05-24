<?php
namespace src;

class class_finder {
    private $id_pattern;
    function __construct(){
        $this->id_pattern  = "/^(?<este>";
        $this->id_pattern .= "([ ]*(?<nsflag>namespace)[ ]*";
        $this->id_pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]+)[ ]*;";
        $this->id_pattern .= ")|";
        $this->id_pattern .= "([ ]*(?<ifflag>interface)[ ]*";
        $this->id_pattern .= "(?<interface>[0-9a-zA-Z_]+)[ ]*{";
        $this->id_pattern .= ")|(";
        $this->id_pattern .= "(?<final>final|)";
        $this->id_pattern .= "(?<abstract>abstract|)";
        $this->id_pattern .= "[ ]*(?: |)";
        $this->id_pattern .= "(?<tipo>class)(?: )[ ]*";
        $this->id_pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
        $this->id_pattern .= "(implements (?<implements>[0-9a-zA-Z_, ]*)|)[ ]+";
        $this->id_pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]*";
        $this->id_pattern .= "))/m";
    }
    function set_pattern( string $pattern ){
        $this->id_pattern = $pattern;
    }
    
    private $matches;
    private $source = "";
    function matches( string $source ) : Array {
        $this->source = $source;
        $matches = [];
        preg_match_all($this->id_pattern, $source, $matches );
        $this->matches = $matches;
        return $matches;
    }

    function find_bodies() : Array {
        $matches = $this->matches;
        $bodies = [];
        foreach ($matches[0] as $key => $code ) {
            if( $matches[ "nsflag" ][ $key ] == "namespace" ){
                /* TODO: scan for namespaces with body {}
                 */
                continue;
            }
            $pointer = $key;
            while( true ){
                if( $matches[ "ifflag" ][ $key ] == "interface" ){
                    $name = $matches[ "interface" ][ $key ];
                } else {
                    $name = $matches[ "nombretipo" ][ $key] ;
                }
                
                $pointer ++;
                $next_code = $matches[0][$pointer];
                if( $next_code === null ){
                    $body = $this->get_from_class($this->source, $code);
                    $bodies[ $name ] = $body;
                    
                    break;
                }
                if( $matches[ "nsflag" ][ $pointer ] == "namespace" ){
                    continue;
                }
                
                $body = $this->get_between_strings($this->source, $code, $next_code);
                $bodies[ $name ] = $body;
                break;
            }
        }
        return $bodies;
    }
        
    function separar_clases() : Array {
        $bodies = $this->find_bodies();
        
        $matches = $this->matches;
        $lista = [];
        $namespace = "";
        foreach ($matches["tipo"] as $key => $value ) {
            if( $matches[ "nsflag" ][ $key ] == "namespace" ){
                $namespace = $matches[ "nsname" ][ $key ];
                continue;
            }
            if( $value === "class"){
                $name = trim( $matches[ "nombretipo"][$key] );
                $clase = new class_( $name );
                $clase->set_type( "class" );
                $clase->set_extends( $matches["extends"][$key] );
                $clase->set_implements( $matches["implements"][$key] );
                $clase->set_abstract( $matches["abstract"][$key] );
                $clase->set_namespace( $namespace );
                
                $class_source = $bodies[$name];
                $arr = $this->extract_functions($class_source);
                foreach( $arr[0] as $code ){
                    $fn = new function_($code);
                    $clase->set_function($fn->get_name(),$fn->get_params(),$fn->get_return_type());
                }
                $clase->set_body($bodies[$name]);
                
                $lista[] = $clase;
                continue;
            }
            if( $matches[ "ifflag" ][ $key ] == "interface" ){
                $name = trim( $matches[ "interface"][$key] );
                $clase = new class_( $name );
                $clase->set_type( "interface" );
                $clase->set_extends( $matches["extends"][$key] );
                $clase->set_namespace( $namespace );
                $clase->set_body($bodies[$name]);
                $lista[] = $clase;
                continue;
            } 
        }
        return $lista;
    }
    
    function get_between_strings( string $source, string $string1, string $string2 ) : string {
        $strpos1 = strpos($source, $string1 )+strlen($string1);
        $strpos2 = strpos($source, $string2 );
        return substr($source, $strpos1, $strpos2-$strpos1 );
    }
    
    private function get_from_class( string $source, string $string1 ) : string {
        $strpos1 = strpos($source, $string1 )+strlen($string1);
        return substr($source, $strpos1 );
    }
    
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