<?php

/* extract the second item and place it as first
 * then concatenates the rest of the array
 * 
 * cabeza = head
 * resto = remaining items
 * resultado = result
 * 
 */
function permutacion( Array $arr, int $ini ) : Array {
    $resto = $arr;
    $cabeza = array_splice( $resto, $ini,1 );
    $resultado = array_merge( $cabeza , $resto );
    return $resultado;
}




function ejecutar_permutacion( Array $arr, Callable $funcion, Array $cabecera = [] ) {
    if( count( $arr ) == 0 ){
        $funcion( $arr );
        return;
    }
    if( count( $arr ) == 1 ){
        $funcion( $arr );
        return;
    }
    if( count( $arr ) == 2 ){
        $funcion( array_merge( $cabecera, $arr ), 0 );
        $funcion( array_merge( $cabecera, permutacion( $arr, 1 ) ), 1 );
        return;
    }

    for( $index = 0 ; $index < count( $arr ) ; $index ++ ){
        $cabeza = array_slice( $arr, $index, 1 );
        $resto = $arr;
        array_splice( $resto, $index, 1 );
        ejecutar_permutacion($resto, $funcion, array_merge( $cabecera, $cabeza ) );
    }

    
}