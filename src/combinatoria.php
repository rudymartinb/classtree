<?php

function permutacion( Array $arr, int $ini ) : Array {
    $resto = $arr;
    $cabeza = array_splice( $resto, 1,1 );
    $resultado = array_merge( $cabeza , $resto );
    return $resultado;
    
}
function generar_permutaciones( Array $arr = null ) : Array {
    if( is_null( $arr ) or count( $arr ) < 2 ){
        return [ $arr ];
    }
    return [ [ $arr[0], $arr[1] ], permutacion( $arr, 1 ) ];
}