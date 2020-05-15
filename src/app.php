<?php
namespace src;

use function files\get_all_files;
use function files\get_php_files;
use function files\get_sources;
use function files\get_classes_from_sources;

class App {
    private $directory = "";
    function set_directory( string $dir ){
        $this->directory = $dir; 
    }
    
    private $files_names;
    function scan_dir(){
        $this->files_names = get_all_files($this->directory);
    }
    
    private $php_sources;
    function read_sources(){
        $php_files = get_php_files( $this->files_names );
        $this->php_sources = get_sources( $php_files );
    }
    
    private $classes;
    function generate_classes(){
        $this->classes = get_classes_from_sources($this->php_sources);
    }
    
    function generate_interfaces(){
        
    }
    function generate_class_functions(){
        
    }
    function resolve_class_dependencies(){
        
    }
    function resolve_interfaces_dependencies(){
        
    }
    function resolve_functions_dependencies(){
        
    }
    function resolve_levels(){
        
    }
    function calculate_diagram(){
        
    }
    function generate_file( string $output ){
        
    }
    
    
}