<?php

function permutacion( Array $arr, int $ini ) : Array {
    $resto = $arr;
    $cabeza = array_splice( $resto, $ini,1 );
    $resultado = array_merge( $cabeza , $resto );
    return $resultado;
    
}
function generar_permutaciones( Array $arr = null ) : Array {
    if( is_null( $arr ) or count( $arr ) < 2 ){
        return [ $arr ];
    }
    
    $resultado = [];
    $resultado[] = $arr;
    
    $ultimo = $resultado[ count($resultado)-1 ];
    $resultado[] = permutacion( $ultimo, 1 );
    
    if( count( $arr ) == 2 ){
        return $resultado ;
    }
    $ultimo = $resultado[ count($resultado)-1 ];
    $resultado[] = permutacion( $ultimo, 2 );

    $ultimo = $resultado[ count($resultado)-1 ];
    $resultado[] = permutacion( $ultimo, 2 );

    $ultimo = $resultado[ count($resultado)-1 ];
    $resultado[] = permutacion( $ultimo, 1 );

    $ultimo = $resultado[ count($resultado)-1 ];
    $resultado[] = permutacion( $ultimo, 2 );
    
    return $resultado;
}