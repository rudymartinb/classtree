<?php
namespace src;

use function files\get_all_files;
use function files\get_php_files;
use function files\get_sources;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;

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
    
    private $interfaces;
    function generate_interfaces(){
        $this->interfaces = get_interfaces_from_sources($this->php_sources);
    }
//     function generate_class_functions(){
//     }

    function resolve_class_dependencies(){
        foreach( $this->classes as $class ){
            $class->find_extends( $this->classes );
        }
    }
    function is_class_dependencies_resolved() : bool {
        foreach( $this->classes as $class ){
            $class = force_class($class);
            if( ! $class->is_extends_resolved() ){
                return false;
            }
        }
        return true;
    }
    
    function resolve_interfaces_dependencies(){
        foreach ( $this->interfaces as $interface ){
            $interface = force_interface( $interface );
            $interface->resolve_extends( $this->interfaces );
        }
    }

    function is_interfaces_dependencies_resolved() : bool {
        foreach( $this->interfaces as $interface ){
            $interface = force_interface($interface);
            if( ! $interface->is_extends_resolved() ){
                return false;
            }
        }
        return true;
    }
    
    private $parents_classes = [];
    function search_parent_classes(){
        foreach( $this->classes as $class ){
            $class = force_class($class);
            if( ! $class->get_extends() == "" ){
                $this->parents_classes[] = $class;
            }
        }
    }
    
    private $class_levels = [];
    function resolve_trees(){
        $this->class_levels[0] = $this->search_parent( $this->parents_classes );
    }
    private function search_parent( Array $class_list ) : Array {
        $list = [];
        foreach ($class_list as $class ){
            $class = force_class($class);
            if( $class->get_extends() == $class ){
                $list[] = $class;
            }
        }
        return $list;
    }
        
    
    function resolve_levels(){
        
    }
    
    function calculate_diagram(){
        
    }
    function generate_file( string $output ){
        
    }
    
    
}