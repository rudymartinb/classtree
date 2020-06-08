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

global $argv;

$main_script = realpath(dirname($argv[0]));
$project_dir = resolve_project_dir($main_script);

require_once( $project_dir."/src/includes.php" );

// helper function to include all the source files based on the project directory
include_project_files( $project_dir."/" );

/* real job starts here
*/
$app = new App();
$app->set_parameters($argv);

$error = $app->get_error();
if( $error != "" ){
    echo $error."\n";
    return 1;
}

$app->build();

echo "All done! \n";

function resolve_project_dir( string $main_script ){
    $script_dir = realpath(dirname($main_script));
    
    return $script_dir;
}
