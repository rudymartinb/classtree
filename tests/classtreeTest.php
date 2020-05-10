<?php

function get_all_files( string $path ) : Array {
    $dir = dir( $path );
    $list = [];
    while (false !== ( $filename = $dir->read() ) ) {
        if( begins_with_dot($filename) ){
            continue;
        }
        $fullpath = $path."".$filename;
        // test if we have a directory
        if( is_dir( $fullpath ) ){
            $list = array_merge( $list, get_all_files( $fullpath ) );
            continue;
        }
        
        $list[] = $fullpath ;
    }
    return $list; 
}

class classtreeTest extends PHPUnit\Framework\TestCase {
    
    function test_get_files() {
        $path = "/home/rudy/projects/classtree/tests/dummy/";
        $lista = get_all_files( $path );
        $this->assertEquals( 3, count( $lista ) );
        
        var_dump( $lista );
    }
    
    
    /* this test uses a fixed file on tests/dummy dir
     * altering the file will cause this test to fail
     * 
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */
    function test_build_from_dir() {
        $path = "/home/rudy/projects/classtree/tests/dummy/";

        $classtree = new ClassTree();

        $classtree->build_from_dir( $path );
        
        $clases = $classtree->get_clases();

        $this->assertEquals( "father", $clases[0]->get_name() );

        $funciones = $classtree->get_functions("/home/rudy/projects/classtree/tests/dummy/prueba.php", "father");
        $actual = $funciones["nombretipo"][0];
        
        $this->assertEquals("algo1", $actual);
        
        // nombre segunda clase
        $this->assertEquals( "son", $clases[1]->get_name() );
        // nombre clase que extiende segunda clase
        $this->assertEquals( "father", $clases[1]->get_extends() );
        // nombre interface que implementa sgunda clase
        $this->assertEquals( "sarasa_interface", $clases[1]->get_implements()[0] );
        
        
    }

    function test_build_from_file_1() {
        $path = "/home/rudy/projects/classtree/tests/dummy/prueba2.php";
        
        
        $classtree = new ClassTree();
        
        $classtree->build_from_file( $path );
        
        $tree = $classtree->get_tree();

        $this->assertEquals( 1 , $tree->get_num_nodes() );
        
        
    }
    
    
    
    

}

