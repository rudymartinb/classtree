<?php
namespace src;

use function files\get_all_files;
use function files\get_php_files;
use function files\get_sources;
use function files\get_classes_from_sources;
use function files\get_interfaces_from_sources;
use diagram\draw_text;

class App {
    

    private $project_dir;
    // $file is supposed to contain the fullpath of the initial script like __FILE__
    function resolve_project_dir( string $main_script ){
        $bin_dir = realpath(dirname($main_script));
        $this->project_dir = realpath($bin_dir."/..");
        draw_text::set_path( $this->project_dir );
    }
    
    function get_project_dir() : string {
        return $this->project_dir;
        
    }
    
    private $error_msg = "";
    function get_error() : string {
        return $this->error_msg;
    }
    
    private $main_script = "classtree.php";
    function set_parameters( Array $arguments ){
        if( count($arguments) != 3 ){
            $this->error_msg = "ussage: ".$this->main_script." <source_dir> <output_file>";
            return ;
        }
        $this->resolve_project_dir($arguments[0]);
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
        $this->output_file = $file;
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
        $classes = [];
 
        $tree = new class_tree_builder();
        foreach ($this->php_sources as $source ){
        	$tree->add_source($source);
        }
        $tree->resolve_hierarchy();
        $tree->draw( $this->output_file );
        
//         $this->classes = $classes;
    }

    function generate_file( ){
        // echo "doing nothing ATM !";
    }
    
    function build(){
        $this->scan_dir();
        $this->read_sources();
        $this->generate_classes();
        
        
        $this->generate_file();
        
    }
    
    
}