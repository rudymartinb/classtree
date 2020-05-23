<?php
namespace files;


use src\class_finder;

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
    $finder = new class_finder();
    $matches = $finder->matches($source);
    
    $clases = separar_clases($matches);
    return $clases;
}

