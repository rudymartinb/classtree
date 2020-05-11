<?php

class classtreeTest extends PHPUnit\Framework\TestCase {

    /* this test uses fixed files on tests/dummy dir
     * adding or removing files will cause this test to fail
     *
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */
    
    function test_get_files() {
        $path = "/home/rudy/projects/classtree/tests/dummy";
        $lista = get_all_files( $path );
        $this->assertEquals( 3, count( $lista ) );
    }

    function test_get_source_from_file() {
        $filename = "/home/rudy/projects/classtree/tests/dummy/prueba2.php";
        $lista = get_source( $filename );
        $this->assertTrue( $lista != ""  );
    }
    
    function test_get_sources() {
        $path = "/home/rudy/projects/classtree/tests/dummy";
        $files = get_all_files( $path );
        $sources = get_sources( $files );
        $this->assertEquals( 3, count( $sources ) );
    }

    
    function get_source_prueba2() : string {
        $source = "<?php
namespace sarasa;
            
class father {
    public function algo(): string {
            
    }
}";
        return $source;
    }
    function get_class() : clases {
        
    }
    
    function test_get_classes() {
        $source = $this->get_source_prueba2();
        $classes = get_clases( $source );
        $this->assertEquals( 1, count( $classes ) );
        $class = $classes[0];
        $this->assertEquals( 1, count( $classes ) );

    }

    function test_get_class_1() {
        $source = $this->get_source_prueba2();
        $classes = get_clases( $source );
        var_dump( $classes[0] );
        $this->assertEquals( 1, count( $classes ) );
        //         var_dump($classes);
    }
    
    
    /* this test uses fixed files on tests/dummy dir
     * altering the file will cause this test to fail
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

