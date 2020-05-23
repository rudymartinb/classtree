<?php
/*
 * codigo de ejemplo usado para alimentar las pruebas unitarias
 * 
 * una vez terminado NO TOCAR !!!
 */

// class commented_out {
   
namespace something;

use DateTime;

interface sarasa_interface {
    function algo() : string;
    function algo1() : string;
    function algo2() : string;
    
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
