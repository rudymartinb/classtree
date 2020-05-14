<?php

function get_source_prueba() : string {
    $source = '<?php
/*
 * codigo de ejemplo usado para alimentar las pruebas unitarias
 *
 * una vez terminado NO TOCAR !!!
 */
namespace something;
        
use DateTime;
        
interface sarasa_interface {
    function algo() : string;
        
}
class father {
    function algo1( int $uno, string $dos ): string {
        
    }
        
    function algo2( int $uno, string $dos ) {
    }
    function algo3( ) : bool {
    }
    function algo4( ) {
    }
}
        
class son extends father implements sarasa_interface {
    public function algo(): string {
        
    }
    public function algomas(): DateTime {
        
    }
}
        
class orphan implements sarasa_interface {
    public function algo() : string {
        
    }
}
';
    return $source;
}



function get_source_prueba2() : string {
    $source = "<?php
namespace sarasa;
        
class father {
    public function algo(): string {
        
    }
}";
    return $source;
}

function get_source_prueba2_2() : string {
    $source = "<?php
namespace sarasa;
        
class son extends father {
    public function algo(): string {
        
    }
}";
    return $source;
}
