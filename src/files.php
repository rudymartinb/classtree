<?php
namespace files;


use src\clase;

function begins_with_dot( string $entry ) : bool {
    return substr( $entry, 0,1 ) == ".";
}

function is_php( string $entry ) : bool {
    return substr( $entry, -4 ) == ".php";
}

function get_all_files( string $path ) : Array {
    if( !is_dir( $path ) ) {
        return [];
    }
    $dir = dir( $path );
    $list = [];
    while(  ( $filename = $dir->read() ) !== false  ) {
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

/* let's be optimistic. 
 * let's pretend the files exist on disk 
 * (anything could happen in the middle but I wont worry yet)
*/
function get_php_files( Array $list ) : Array {
    $phpfiles = []; 
    foreach( $list as $filename ){
        if( ! is_string($filename) ){
            continue;
        }
        if( is_php($filename)){
            $phpfiles[] = $filename;
        }
    }
    return $phpfiles;
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
