<?php

use src\App;

class AppTest extends PHPUnit\Framework\TestCase {
    
    function test_empty_cli_parameters(){
        // mock $argv
        $arguments = [];
        
        $app = new App();
        $app->set_parameters( $arguments );
        
        $this->assertNotEquals( "", $app->get_error() );
    }

    function test_get_project_dir(){
        $file = "/home/rudy/projects/classtree/bin/classtree.php";

        $app = new App();
        $app->resolve_project_dir( $file );
        
        $this->assertEquals( "/home/rudy/projects/classtree", $app->get_project_dir() );
    }
    

//     TODO: enable when grid() is able to use Tree()
    function test_new(){

        $app = new App();
        $app->set_directory( "./tests/dummy" );
        $file = "/tmp/output.txt";
        $app->set_output_file($file);

        $app->build();
        
        $this->assertFileExists( $file );
        
        return;
        
    }

    
}

