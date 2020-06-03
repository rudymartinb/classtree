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
    
    require_once $path.'src/files.php';
    
    // diagrams
    require_once $path.'src/diagram/vertical_layout.php';
    require_once $path.'src/diagram/draw_text.php';
    
    require_once $path.'src/diagram/diagram.php';
    
    require_once $path.'src/diagram/properties/element_properties.php';
    require_once $path.'src/diagram/element.php';

}


// TODO: move this to the main script
$testGD = get_extension_funcs("gd"); // Grab function list
if (!$testGD){
	echo "GD not even installed.";
	return;
}

putenv('GDFONTPATH=' . realPath('fonts'));

?>