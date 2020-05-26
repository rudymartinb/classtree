<?php
namespace src;

class class_finder {
    private $pattern;
    
    private $matches;
    private $source = "";
    
    function __construct( string $source ){
        $this->pattern  = "/^(?<original>";
        $this->pattern .= "(";
//         $this->pattern .= "(?<final>final|)";
//         $this->pattern .= "(?<abstract>abstract|)";
        $this->pattern .= "[ ]*(?: |)";
        $this->pattern .= "(?:class)(?: )[ ]*";
        $this->pattern .= "(?<classname>[0-9a-zA-Z_]+)[ ]*";
        $this->pattern .= "( implements (?<implements>[0-9a-zA-Z_, ]*)|)[ ]*";
        $this->pattern .= "( extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]*";
        $this->pattern .= "))";
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
    

    function matches( string $source ) : Array {
    	$this->source = $source;
    	$matches = [];
    	preg_match_all($this->pattern, $source, $matches );
    	$this->matches = $matches;
    	return $matches;
    }
    
    
//     function set_pattern( string $pattern ){
//         $this->id_pattern = $pattern;
//     }
    

//     function find_bodies() : Array {
//         $matches = $this->matches;
//         $bodies = [];
//         foreach ($matches[0] as $key => $code ) {
//             if( $matches[ "nsflag" ][ $key ] == "namespace" ){
//                 /* TODO: scan for namespaces with body {}
//                  */
//                 continue;
//             }
//             $pointer = $key;
//             while( true ){
//                 if( $matches[ "ifflag" ][ $key ] == "interface" ){
//                     $name = $matches[ "interface" ][ $key ];
//                 } else {
//                     $name = $matches[ "nombretipo" ][ $key] ;
//                 }
                
//                 $pointer ++;
//                 $next_code = $matches[0][$pointer];
//                 if( $next_code === null ){
//                     $body = $this->get_from_class($this->source, $code);
//                     $bodies[ $name ] = $body;
                    
//                     break;
//                 }
//                 if( $matches[ "nsflag" ][ $pointer ] == "namespace" ){
//                     continue;
//                 }
                
//                 $body = $this->get_between_strings($this->source, $code, $next_code);
//                 $bodies[ $name ] = $body;
//                 break;
//             }
//         }
//         return $bodies;
//     }
        
//     function separar_clases() : Array {
//         $bodies = $this->find_bodies();
        
//         $matches = $this->matches;
//         $lista = [];
//         $namespace = "";
//         foreach ($matches["tipo"] as $key => $value ) {
//             if( $matches[ "nsflag" ][ $key ] == "namespace" ){
//                 $namespace = $matches[ "nsname" ][ $key ];
//                 continue;
//             }
//             if( $value === "class"){
//                 $name = trim( $matches[ "nombretipo"][$key] );
//                 $clase = new class_( $name );
//                 $clase->set_type( "class" );
//                 $clase->set_extends( $matches["extends"][$key] );
//                 $clase->set_implements( $matches["implements"][$key] );
//                 $clase->set_abstract( $matches["abstract"][$key] );
//                 $clase->set_namespace( $namespace );
                
//                 $class_source = $bodies[$name];
//                 $arr = $this->extract_functions($class_source);
//                 foreach( $arr[0] as $code ){
//                     $fn = new function_($code);
//                     $clase->set_function($fn->get_name(),$fn->get_params(),$fn->get_return_type());
//                 }
//                 $clase->set_body($bodies[$name]);
                
//                 $lista[] = $clase;
//                 continue;
//             }
//             if( $matches[ "ifflag" ][ $key ] == "interface" ){
//                 $name = trim( $matches[ "interface"][$key] );
//                 $clase = new class_( $name );
//                 $clase->set_type( "interface" );
//                 $clase->set_extends( $matches["extends"][$key] );
//                 $clase->set_namespace( $namespace );
//                 $clase->set_body($bodies[$name]);
//                 $lista[] = $clase;
//                 continue;
//             } 
//         }
//         return $lista;
//     }
    
//     function get_between_strings( string $source, string $string1, string $string2 ) : string {
//         $strpos1 = strpos($source, $string1 )+strlen($string1);
//         $strpos2 = strpos($source, $string2 );
//         return substr($source, $strpos1, $strpos2-$strpos1 );
//     }
    
//     private function get_from_class( string $source, string $string1 ) : string {
//         $strpos1 = strpos($source, $string1 )+strlen($string1);
//         return substr($source, $strpos1 );
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
