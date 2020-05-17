<?php
namespace src;

use function files\get_all_files;
use function files\get_php_files;
use function files\get_sources;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;

class App {
    function set_parameters( Array $argv ){
        $this->set_directory($argv[1]);
        $this->set_output_file( $argv[2]);
    }
    
    private $directory = "";
    function set_directory( string $dir ){
        $this->directory = $dir; 
    }
    function get_directory(){
        return $this->directory;
    }
    
    private $output_file;
    function set_output_file( string $file ){
        
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
            if( $class->get_extends() == "" ){
                $this->parents_classes[] = $class;
            }
        }
    }
    function get_parent_classes() : Array {
        return $this->parents_classes;
    }
    
    private $class_levels = [];
    private $current_level ;
    
    function resolve_levels(){
        $this->current_level = 0;
        
        $this->search_childs( $this->parents_classes );
    }
        
    private function search_childs( Array $parents ) {
        $this->class_levels[ $this->current_level ] = $parents;
        $childs = [];
        foreach ($parents as $parent ){
            $parent = force_class( $parent );
            foreach ( $this->classes as $class ){
                $class = force_class($class);
                if( $class->get_extends() == $parent->get_name() ){
                    $childs[] = $class;
                }
            }

        }
        if( count( $childs ) == 0 ){
            return;
        }
        $this->current_level++;
        $this->search_childs($childs);
    }
    
    function get_class_levels() : Array {
        return $this->class_levels;
    }
    
    /*
     * now I have the appropiate level for each class
     * building a tree is more easy
     * I just have to iterate over the parents,
     * create one tree per parent
     * and add search for subclases on each level until I find none
     */
    private $trees ;
    function create_trees(){
        $this->trees = [];
        $this->current_level = 0;
        foreach( $this->parents_classes as $parent ){
            $this->trees[] = [ $parent->get_name(), $this->get_children_nodes( $parent->get_name() ) ];
        }
    }
    function get_children_nodes( string $name ) : Array {
        foreach( $this->class_levels as $parent ){
            $this->trees[] = [ $parent->get_name(), $this->get_children_nodes( $parent->get_name() ) ];
        }
        //         foreach
    }
    
    
    function calculate_diagram(){
        
    }
    function generate_file( string $output ){
        
    }
    
    
}