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
    
    function separar_clases() : Array {
        $matches = $this->matches;
        $lista = [];
        $namespace = "";
        foreach ($matches["tipo"] as $key => $value ) {
            if( $matches[ "nsflag" ][ $key ] == "namespace" ){
                $namespace = $matches[ "nsname" ][ $key ];
                continue;
            }
            if( $value == "class"){
                $clase = new class_( trim( $matches[ "nombretipo"][$key] ) );
                $clase->set_type( "class" );
                $clase->set_extends( $matches["extends"][$key] );
                $clase->set_implements( $matches["implements"][$key] );
                $clase->set_abstract( $matches["abstract"][$key] );
                $clase->set_namespace( $namespace );
                
//                 $this_class = $matches["nombretipo"][$key];
//                 if( $key < count( $matches[0])-1 ){
//                     $next_class = $matches["nombretipo"][$key+1];
//                     $body = $this->get_between_strings($this->source, $this_class, $next_class);
//                 } else {
//                     $body = $this->get_from_class($this->source, $this_class, $next_class);
//                 }
                
//                 $funcs = $this->extract_functions($body);
//                 foreach ($funcs as $key => $fn ){
//                     $name = $fn["fnname"][$key];
//                     $parameters = $fn["fnparams"][$key];
//                     $rettype = $fn["fnrettype"][$key];
//                     $clase->set_function($name, $parameters);
//                 }
                
                /* before that
                 * we need to scan the class body for functions
                 */
                
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