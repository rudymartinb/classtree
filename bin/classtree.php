<?php
/*
 * since this program might be run from anywhere in the filesystem
 * we need a way to locate the project files
 * 
 * for that, we asume the script is called from the bin directory inside the project 
 * 
 * later I will investigate if there's an alternative 
 */
use src\App;

global $argv; // TODO: is this really needed?

$main_script = realpath(dirname($argv[0]));
$project_dir = resolve_project_dir($main_script);

require_once( $project_dir."/src/includes.php" );

include_project_files( $project_dir."/" );

// var_dump( $argv );
/* real job is supposed to starts here
*/
$app = new App();
$app->set_parameters($argv);

// $error = $app->get_error()."\n";
// if( $error != "" ){
//     echo $error;
//     return 1;
// }

$app->scan_dir();
$app->read_sources();
$app->generate_classes();
$app->generate_interfaces();
$app->resolve_class_dependencies();

$app->resolve_interfaces_dependencies();

$app->search_parent_classes();

$app->resolve_levels();
$app->create_trees();
$file = "/tmp/output.txt";
$app->generate_file( $argv[2] );

echo "All done! \n";

function resolve_project_dir( string $main_script ){
    $script_dir = realpath(dirname($main_script));
    
    return $script_dir;
}
