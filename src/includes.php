<?php
function include_project_files( string $path ){
	require_once $path.'src/traits/finder.php';
	
//     require_once $path.'src/parameter_.php';

	require_once $path.'src/parameters_finder.php';
//     require_once $path.'src/function_.php';
    require_once $path.'src/function_finder.php';
//     require_once $path.'src/class_.php';
    require_once $path.'src/class_finder.php';
    require_once $path.'src/trait_finder.php';
    require_once $path.'src/namespace_finder.php';
    
    require_once $path.'src/files.php';
    
    // tree2
    require_once $path.'src/Trees.php';
    
//     require_once $path.'src/grid.php';

    
    
//     require_once $path.'src/app.php';
    
}
?>