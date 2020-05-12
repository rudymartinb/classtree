<?php

use nodes\node_clase;
use nodes\tree;
use src\clase;


function get_all_files( string $path ) : Array {
    $dir = dir( $path );
    $list = [];
    while (false !== ( $filename = $dir->read() ) ) {
        if( begins_with_dot($filename) ){
            continue;
        }
        $fullpath = $path."/".$filename;
        // test if we have a directory
        if( is_dir( $fullpath ) ){
            $list = array_merge( $list, get_all_files( $fullpath ) );
            continue;
        }
        
        $list[] = $fullpath ;
    }
    return $list;
}

function get_source( string $filename ) : string {
    if( ! file_exists( $filename ) ){
        return "";
    }
    return file_get_contents( $filename );
}
function get_sources( Array $files ) : Array {
    $sources = []; 
    foreach ($files as $filename ){
        $sources[] = get_source($filename);
    }
    return $sources;
}


function begins_with_dot( string $entry ) : bool {
    return substr( $entry, 0,1 ) == ".";
}
function is_php( string $entry ) : bool {
    return substr( $entry, -4 ) == ".php";
}


/*
 * this generates one class object from the matches found
 * during source search by one of the build_from* functions
 */
function separar_clases( Array $matches ) : Array {
    $lista = [];
    $namespace = "";
    foreach ($matches["tipo"] as $key => $value ) {
        if( $value == "namespace" ){
            $namespace = $matches[ "nombretipo" ][ $key ];
            continue;
        }
        if( $value != "class" ){
            continue;
        }
        
        $clase = new clase( $matches[ "nombretipo"][$key] );
        $clase->set_extends( $matches["extends"][$key] );
        $clase->set_implements( $matches["implements"][$key] );
        $clase->set_namespace( $namespace );
        
        $lista[] = $clase;
    }
    return $lista;
}

/* perhaps the word "type" is not adecuate here
 * but identifiers is a bit too long ...
 *
 * TODO: add an array with the list of identifiers
 * ie: add "trait" later
 */
function get_types_from_source( string $filename ): Array {
    $sourcecode = file_get_contents( $filename );
    
    $pattern  = "/(?<tipo>class|interface|namespace)[ ]*";
    $pattern .= "(?<nombretipo>[0-9a-zA-Z_]*)[ ]*";
    $pattern .= "(extends (?<extends>[0-9a-zA-Z_]*)|)[ ]*";
    $pattern .= "(implements (?<implements>[0-9a-zA-Z_]*)|)*[ {]*/";
    
    $matches = [];
    preg_match_all($pattern, $sourcecode, $matches );
    
    return $matches;
}

function get_clases( string $source ) : Array {
    $pattern  = "/(?<tipo>class|interface|namespace)[ ]*";
    $pattern .= "(?<nombretipo>[0-9a-zA-Z_]*)[ ]*";
    $pattern .= "(extends (?<extends>[0-9a-zA-Z_]*)|)[ ]*";
    $pattern .= "(implements (?<implements>[0-9a-zA-Z_]*)|)*[ {]*/";
    
    $matches = [];
    preg_match_all($pattern, $source, $matches );
    
    $clases = separar_clases($matches);
    return $clases;
}


class ClassTree {
    
    private $nodos = [] ;
    
    private $tree;
    function get_tree() : tree {
        return $this->tree;
    }
    
    private $clases = [];
    function get_clases() : Array {
        return $this->clases;
    }
    
    function __construct(){
        $this->tree = new tree();
    }
    
    function build_from_dir( string $path ) {
        $dir = dir( $path );
        
        while (false !== ( $filename = $dir->read() ) ) {
            // prevent going back on the dir tree
            // and scanning "hidden" directories and files
            if( begins_with_dot($filename) ){
                continue;
            }
            
            
            $fullpath = $path."/".$filename;
            // test if we have a directory
            if( is_dir( $fullpath ) ){
                $this->build_from_dir( $fullpath );
                continue;
            }
            
            // exclude all other files
            // TODO: include others extendions, like .inc ?
            if( ! is_php($filename) ){
                continue;
            }
            
            $matches = get_types_from_source( $fullpath );
            $clases = separar_clases( $matches );
            
            foreach( $clases as $clase ){
                $node = new node_clase( $clase->get_name() );
                $this->tree->add_node($node);
            }
            $this->clases = $this->clases + $clases;
            
        }
        return ;
    }
    
    function build_from_file( string $filename ) : Array {
        $lista = [];
        
        if( begins_with_dot( $filename ) ){
            return $lista;
        }
        
        if( ! is_php($filename) ){
            return $lista;
        }
        
        $lista[ $filename ] = ""; 
        
        $matches = get_types_from_source( $filename );
        $clases = separar_clases( $matches );

        foreach( $clases as $clase ){
            $node = new node_clase( $clase->get_name() );
            $this->tree->add_node($node);
        }
        
        $this->clases = array_merge( $this->clases , $clases );
            
        return $clases;
    }
    
    
    

    /* no se si la voy a terminar usando
     * por cuanto esto implicaria revisar el codigo interno de cada funcion linea por linea
     * para ver las dependencias que tiene.
     * 
     * y aparte tengo otro problema:
     * no puedo saber el resultado de llamadas a metodos de objetos
     * sin consultar el objeto en cuestion
     * 
     * por lo tanto es como que cada instancia del objeto clase 
     * deberia tener un atributo que diga si se termino de consultar todo o no
     * 
     */
    function get_functions( string $filename, string $class ): Array {
        $sourcecode = file_get_contents( $filename );

        /* extract classes from source
         */
        $classpart = "class ".$class."";
        
        $pattern  = "/";
        $pattern .= "(?:(?!".$classpart.").)";
        $pattern .= "(?:".$classpart.")";
        $pattern .= ".+?";
        $pattern .= "(?:(?=class))";
        $pattern .= "/s";
                
        $matches = [];
        preg_match_all( $pattern, $sourcecode, $matches );
        
        $classbody = $matches[0][0];
        if( is_null( $classbody ) ){
            return [];
        }

        /* extract functions from class body
         */
        $pattern  = "/";
        $pattern .= "(?:function) ";
        $pattern .= "(?<nombretipo>[0-9a-zA-Z_]*)[ ]*";
        $pattern .= "[(]{1}";
        $pattern .= "(?<params>[ $0-9a-zA-Z_,]*)";
        $pattern .= "[)]{1}";
        $pattern .= "(?<ret>[ :$0-9a-zA-Z_,]*)";
        $pattern .= "/s";
        
        $func_matches = [];
        preg_match_all( $pattern, $classbody, $func_matches  );
                
        return $func_matches;
    }
    
    
}