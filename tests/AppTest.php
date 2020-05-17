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
    
    
    function test_new(){

        $app = new App();
        $app->set_directory( "./tests/dummy" );
        
        $app->scan_dir();
        $app->read_sources();
        $app->generate_classes();
        $app->generate_interfaces();
//         $app->generate_class_functions();
        $app->resolve_class_dependencies();
        $this->assertTrue( $app->is_class_dependencies_resolved() );
        
        $app->resolve_interfaces_dependencies();
        $this->assertTrue( $app->is_interfaces_dependencies_resolved() );
        
//         $app->resolve_functions_dependencies();
        
        $app->search_parent_classes();

        $app->resolve_levels();
        $levels = $app->get_class_levels();
        $this->assertEquals( 2, count( $levels ) );
        
        
        $app->create_trees();
        
//         $app->resolve_levels();
        
//         $app->calculate_diagram();
        $file = "/tmp/output.txt";
        $app->generate_file( $file );
        $this->assertFileExists( $file );
        
        return;
        
    }
}

