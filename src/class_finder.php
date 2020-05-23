<?php
namespace src;

// I call it "function" but it should be read as class method.
// (keyword "function" is used by PHP, not my fault)
class function_ {
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
        $this->params = $params;
    }
    function get_params() : Array {
        return $this->params;
    }
    
    private $rettype;
    
    
}
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
        $this->id_pattern .= "(?<final>final|)(?<abstract>abstract|)[ ]*(?<tipo>class(?: ))[ ]*";
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
            if( $value == "class "){
                $clase = new class_( trim( $matches[ "nombretipo"][$key] ) );
                $clase->set_type( "class" );
                $clase->set_extends( $matches["extends"][$key] );
                $clase->set_implements( $matches["implements"][$key] );
                $clase->set_abstract( $matches["abstract"][$key] );
                $clase->set_namespace( $namespace );
                
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