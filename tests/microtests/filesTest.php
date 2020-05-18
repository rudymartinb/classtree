<?php
use function files\get_all_files;
use function files\get_source;
use function files\get_sources;
use function files\get_php_files;
use function files\get_clases;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;
use function files\get_interfaces;


class filesTest extends PHPUnit\Framework\TestCase {
    
    /* this test uses fixed files on tests/dummy dir
     * adding or removing files will cause this test to fail
     *
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */

    function test_get_files_FAIL_1() {
        $path = "/asdfasdf";
        $lista = get_all_files( $path );
        $this->assertEquals( 0, count( $lista ) );
    }
    function test_get_files_FAIL_2() {
        $path = "/bin/bash";
        $lista = get_all_files( $path );
        $this->assertEquals( 0, count( $lista ) );
    }
    
    
    function test_get_files() {
        $path = "./tests/dummy";
        $lista = get_all_files( $path );
        $this->assertEquals( 3, count( $lista ) );
    }
    

    /*
     *     function test_get_files() {
        $path = "/home/rudy/projects/classtree/tests/dummy";
        $count = 0;
        $function = function() use( &$count ) {
            $count ++;
        };
        $lista = get_all_files( $path, $function );
        $this->assertEquals( 3, count( $lista ) );
        $this->assertEquals( 3, $count );
    }
     */

    function test_separate_php_fail(){
        $phpfiles = get_php_files( [] );
        $this->assertEquals( 0, count( $phpfiles ) );
    }

    function test_separate_php_fail_2(){
        $phpfiles = get_php_files( [ null ] );
        $this->assertEquals( 0, count( $phpfiles ) );
    }
    
    function test_separate_php(){
        $path = "./tests/dummy";
        $lista = get_all_files( $path );
        $phpfiles = get_php_files( $lista );
        $this->assertEquals( 3, count( $phpfiles ) );
    }
    
    function test_get_source_from_file() {
        $filename = "./tests/dummy/prueba2.php";
        $lista = get_source( $filename );
        $this->assertTrue( $lista != ""  );
    }
    
    function test_get_sources() {
        $path = "./tests/dummy";
        $files = get_all_files( $path );
        $sources = get_sources( $files );
        $this->assertEquals( 3, count( $sources ) );
    }

    function test_get_class1() {
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
//         $pattern  = "/^(?<tipo>class(?: )|interface(?: ))[ ]*";
//         $pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
//         $pattern .= "(implements (?<implements>[0-9a-zA-Z_,]*)|)[ ]+";
//         $pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]+";
//         $pattern .= "/m";
        
//         $matches = [];
//         preg_match_all($pattern, $source, $matches );
//         var_dump( $matches[0] ); 
        
        $classes = get_clases( $source );

        $this->assertEquals( 3, count( $classes ) );
    }
    
    function test_get_class2() {
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $classes = get_clases( $source );
        $this->assertEquals( 1, count( $classes ) );
    }
    
    function test_get_interface_1() {
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $classes = get_interfaces( $source );
        $this->assertEquals( 1, count( $classes ) );
    }
    
    
    function test_get_classes_from_sources() {
        $path = "./tests/dummy";
        $files = get_all_files( $path );
        $php_sources = get_php_files( $files );
        $sources = get_sources( $php_sources );
        $classes = get_classes_from_sources( $sources );
        $this->assertEquals( 4, count( $classes ) );
    }

//     function test_get_interfaces_from_sources() {
//         $path = "./tests/dummy";
//         $files = get_all_files( $path );
//         $php_sources = get_php_files( $files );
//         $sources = get_sources( $php_sources );
//         $interfaces = get_interfaces_from_sources( $sources );
//         $this->assertEquals( 1, count( $interfaces ) );
//     }


    
    
    
    // mocks
    function generate_1_class() : Array {
        $source = get_source_prueba2();
        $classes = get_clases( $source );
        return $classes;
    }
    
    function generate_2_class() : Array {
        $source = get_source_prueba();
        $classes = get_clases( $source );
        return $classes;
    }
    function generate_1_separated_classes() : Array {
        $source2 = get_source_prueba2_2();
        $classes2 = get_clases( $source2 );
        return $classes2;
    }
    
    function test_array_search() {
        $searchfor = "sarasa";
        $arr = [];
        $arr[] = "a";
        $arr[] = "sara";
        $arr[] = "asara";
        $arr[] = "asarasa";
        $arr[] = "sarasa";
        
        $this->assertEquals( 4, array_search($searchfor, $arr));
    }
    
    function test_grep(){
        $source = get_source("src/class_.php"); 
                
        $pattern  = "/[ ]*(?<tipo>class )[ ]*";
        $pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
        $pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|).*[ {]+";
        $pattern .= "/";
        
        $matches = [];
        preg_match_all($pattern, $source, $matches );
        
        var_dump( $matches[0] );
        $this->assertEquals( "class class_ implements class_interface  {", $matches[0][0] );
        
    }
    
}
