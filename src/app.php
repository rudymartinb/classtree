<?php
namespace src;

use function files\get_all_files;
use function files\get_php_files;
use function files\get_sources;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;

class App {
    

    private $project_dir;
    // $file is supposed to contain the fullpath of the initial script like __FILE__
    function resolve_project_dir( string $main_script ){
        $bin_dir = realpath(dirname($main_script));
        $this->project_dir = realpath($bin_dir."/..");
    }
    function get_project_dir() : string {
        return $this->project_dir;
        
    }
    
    private $error_msg;
    function get_error() : string {
        return $this->error_msg;
    }
    
    private $main_script = "classtree.php";
    function set_parameters( Array $arguments ){
        if( count($arguments) < 3 ){
            $this->error_msg = "ussage: ".$this->main_script." <source_dir> <output_file>";
            return ;
        }
        $this->set_directory( $arguments[1]);
        $this->set_output_file( $arguments[2]);
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
        $this->trees = get_tree($this->classes);
        var_dump( $this->trees );
    }
    
    
    function calculate_diagram(){
        
    }
    function generate_file( string $output ){
        $text = textoutput($this->trees);
        
    }
    
    
}