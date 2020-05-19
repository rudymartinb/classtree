<?php
function include_project_files( string $path ){
    require_once $path.'src/class_finder.php';
    require_once $path.'src/files.php';
    require_once $path.'src/get_tree.php';
    require_once $path.'src/grid.php';
    
//     require_once $path.'src/get_interfaces_tree.php';
//     require_once $path.'src/interface_.php';

    require_once $path.'src/class_.php';
    
    require_once $path.'src/app.php';
    
    require_once $path.'src/textoutput.php';

}
?>