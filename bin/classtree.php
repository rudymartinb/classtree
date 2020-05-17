<?php

use src\App;

global $argv; // TODO: is really needed?

$main_script = realpath(dirname(__FILE__));
// echo $main_script."\n";
$project_dir = resolve_project_dir($main_script);
// echo $project_dir ."\n";

require_once( $project_dir."/src/includes.php" );

include_project( $project_dir );

$app = new App();
$app->set_parameters($argv);

echo "All done!";

function resolve_project_dir( string $main_script ){
    $script_dir = realpath(dirname($main_script));
    
    return $script_dir;
}
