<?php
namespace files;


use src\class_;
use src\interface_;

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

function get_classes_from_sources( Array $sources ) : Array {
    $classes = [];
    foreach ($sources as $source ){
        $tmp = get_clases($source);
        $classes = array_merge( $classes , $tmp );
    }
    return $classes;
}

function get_interfaces_from_sources( Array $sources ){
    $interfaces = [];
    foreach ($sources as $source ){
        $tmp = get_interfaces($source);
        $interfaces = array_merge( $interfaces , $tmp );
    }
    return $interfaces;
}


function get_clases( string $source ) : Array {
    $pattern  = "/^(?<tipo>class(?: )|interface(?: )|namespace(?: ))[ ]*";
    $pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
    $pattern .= "(implements (?<implements>[0-9a-zA-Z_,]*)|)[ ]+";
    $pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]+";
    $pattern .= "/m";
    
    $matches = [];
    preg_match_all($pattern, $source, $matches );
    
    $clases = separar_clases($matches);
    return $clases;
}

function get_interfaces( string $source ) : Array {
    $pattern  = "/^[ ]*(?<tipo>interface(?: ))[ ]*";
    $pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
    $pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]+";
    $pattern .= "/m";
    
    $matches = [];
    preg_match_all($pattern, $source, $matches );
//     var_dump($matches);
    $clases = separar_interfaces($matches);
//     var_dump($clases);
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
        if( trim( $value ) == "namespace" ){
            $namespace = $matches[ "nombretipo" ][ $key ];
            continue;
        }
        if( trim( $value ) != "class" ){
            continue;
        }
        
        $clase = new class_( trim( $matches[ "nombretipo"][$key] ) );
        $clase->set_extends( $matches["extends"][$key] );
        $clase->set_implements( $matches["implements"][$key] );
        $clase->set_namespace( $namespace );
        
        $lista[] = $clase;
    }
    return $lista;
}

function separar_interfaces( Array $matches ) : Array {
    $lista = [];
    $namespace = "";
    foreach ($matches["tipo"] as $key => $value ) {
        if( trim( $value ) == "namespace" ){
            $namespace = $matches[ "nombretipo" ][ $key ];
            continue;
        }
        if( trim( $value ) != "interface" ){
            continue;
        }
        
        $clase = new interface_( $matches[ "nombretipo"][$key] );
        if( $matches["extends"][$key] != "" ){
            $clase->set_extends( $matches["extends"][$key] );
        }
        
        if( $namespace != "" ){
            $clase->set_namespace( $namespace );
        }
        
        $lista[] = $clase;
    }
//     var_dump($lista);
    return $lista;
}


/* perhaps the word "type" is not adecuate here
 * but identifiers is a bit too long ...
 *
 * TODO: add an array with the list of identifiers
 * ie: add "trait" later
 */
// function get_types_from_source( string $filename ): Array {
//     $sourcecode = file_get_contents( $filename );
    
//     $pattern  = "/(?<tipo>class|interface|namespace)[ ]*";
//     $pattern .= "(?<nombretipo>[0-9a-zA-Z_]*)[ ]*";
//     $pattern .= "(extends (?<extends>[0-9a-zA-Z_]*)|)[ ]*";
//     $pattern .= "(implements (?<implements>[0-9a-zA-Z_]*)|)*[ {]*/";
    
//     $matches = [];
//     preg_match_all($pattern, $sourcecode, $matches );
    
//     return $matches;
// }
