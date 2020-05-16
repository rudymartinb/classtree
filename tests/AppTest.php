<?php

use src\App;

class AppTest extends PHPUnit\Framework\TestCase {
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
        var_dump($app);
        $this->assertTrue( $app->is_interfaces_dependencies_resolved() );
        
//         $app->resolve_functions_dependencies();
        
        $app->search_parent_classes();
        $app->resolve_levels();
        $app->resolve_trees();
        $app->calculate_diagram();
        $app->generate_file( "/tmp/output.jpg" );
        
        
        return;
        
    }
}

