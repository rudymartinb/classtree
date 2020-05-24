<?php

use function files\get_all_files;
use function files\get_source;
use function files\get_sources;
use function files\get_php_files;
use function files\get_clases;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;
use function files\get_interfaces;
use src\class_finder;

class filesTest extends PHPUnit\Framework\TestCase {

    
    
    /* this test uses fixed files on tests/dummy dir
     * adding or removing files will cause this test to fail
     *
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */

    function test_get_files_FAIL_1() {
        $path = "/asdfasdf";
        $source = get_all_files( $path );
        $this->assertEquals( 0, count( $source ) );
    }
    function test_get_files_FAIL_2() {
        $path = "/bin/bash";
        $source = get_all_files( $path );
        $this->assertEquals( 0, count( $source ) );
    }
    
    
    function test_get_files() {
        $path = "./tests/dummy";
        $source = get_all_files( $path );
        $this->assertEquals( 3, count( $source ) );
    }


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
        $source = get_all_files( $path );
        $phpfiles = get_php_files( $source );
        $this->assertEquals( 3, count( $phpfiles ) );
    }
    
    function test_get_source_from_file() {
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        $this->assertTrue( $source != ""  );
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
        
        $finder = new class_finder();
        $matches = $finder->matches($source );

        $classes = $finder->separar_clases();

        $this->assertEquals( 4, count( $classes ) );
    }
    
    function test_get_class2() {
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $finder->matches($source );
        $classes = $finder->separar_clases();
        
        $this->assertEquals( 1, count( $classes ) );
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
    
    

}
