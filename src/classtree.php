<?php

use nodes\node_clase;
use nodes\tree;

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

function begins_with_dot( string $entry ) : bool {
    return substr( $entry, 0,1 ) == ".";
}
function is_php( string $entry ) : bool {
    return substr( $entry, -4 ) == ".php";
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
    
    function build_from_dir( string $path, array $lista = [] ) : array {
        $dir = dir( $path );
        
        while (false !== ($entry = $dir->read())) {
            // prevent going back on the dir tree
            // and scanning "hidden" directories
            if( begins_with_dot($entry) ){
                continue;
            }
            
            $newpath = $path."/".$entry;
            if( is_dir( $newpath ) ){
                $this->build_from_dir( $newpath );
            }
            if( ! is_php($entry) ){
                continue;
            }
            
            $matches = get_types_from_source( $newpath );
            $clases = separar_clases( $matches );
            
            foreach( $clases as $clase ){
                $node = new node_clase( $clase->get_name() );
                $this->tree->add_node($node);
            }
            $this->clases = $this->clases + $clases;
            
        }
        return $lista;
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