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
//         var_dump($app);
        $this->assertTrue( $app->is_interfaces_dependencies_resolved() );
        
//         $app->resolve_functions_dependencies();
        
        $app->search_parent_classes();
        $parents = $app->get_parent_classes();
//         var_dump($parents);
        $app->resolve_trees();
        $levels = $app->get_class_levels();
        foreach( $levels as $level ){
            var_dump($level);
        }
        
        
        
        $app->resolve_levels();
        
        $app->calculate_diagram();
        $app->generate_file( "/tmp/output.jpg" );
        
        
        return;
        
    }
}

