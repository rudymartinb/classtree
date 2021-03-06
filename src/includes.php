<?php
function include_project_files( string $path ){
	// traits
	require_once $path.'src/src/traits/finder.php';
	require_once $path.'src/src/traits/finder_functions.php';
	
	// source scanners
	require_once $path.'src/src/parameters_finder.php';
    require_once $path.'src/src/function_finder.php';
    require_once $path.'src/src/class_finder.php';
    require_once $path.'src/src/interface_finder.php';
    require_once $path.'src/src/trait_finder.php';
    require_once $path.'src/src/usetrait_finder.php';
    require_once $path.'src/src/namespace_finder.php';

    // collectors
    require_once $path.'src/src/collector.php';
    require_once $path.'src/src/class_collector.php';
    require_once $path.'src/src/interface_collector.php';
    
    require_once $path.'src/src/node.php';
    
    require_once $path.'src/src/traits/node_positions.php';
    
    
    // tree builders
    require_once $path.'src/src/tree_builder.php';
    require_once $path.'src/src/class_tree_builder.php';
    require_once $path.'src/src/interface_tree_builder.php';
    
    // misc functions
    require_once $path.'src/files.php';
    
    // diagrams
    require_once $path.'src/diagram/vertical_layout.php';
    require_once $path.'src/diagram/draw_text.php';
    require_once $path.'src/diagram/draw_line.php';
    
    require_once $path.'src/app.php';
}


// TODO: move this to the main script
$testGD = get_extension_funcs("gd"); // Grab function list
if (!$testGD){
	echo "GD not even installed.";
	return;
}

putenv('GDFONTPATH=' . realPath('fonts'));

?>