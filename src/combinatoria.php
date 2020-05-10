<?php

function permutacion( Array $arr, int $ini ) : Array {
    $resto = $arr;
    $cabeza = array_splice( $resto, 1,1 );
    $resultado = array_merge( $cabeza , $resto );
    return $resultado;
    
}
function generar_permutaciones( Array $arr = null ) : Array {
    return [ $arr ];
}