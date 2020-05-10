<?php

/* extract the second item and place it as first
 * then concatenates the rest of the array
 * 
 * cabeza = head
 * resto = remaining items
 * resultado = result
 * 
 */
function permutate( Array $arr, int $ini ) : Array {
    $resto = $arr;
    $cabeza = array_splice( $resto, $ini,1 );
    $resultado = array_merge( $cabeza , $resto );
    return $resultado;
}


function ejecutar_permutacion( Array $arr, Callable $funcion, Array $cabecera = [] ) {
    // edge cases 
    if( count( $arr ) <= 1 ){
        $funcion( $arr );
        return;
    }
    
    if( count( $arr ) == 2 ){
        /* funcion is called twice 
         * because array has 2 elements
         */
        $funcion( array_merge( $cabecera, $arr ) );
        $funcion( array_merge( $cabecera, permutate( $arr, 1 ) ) );
        return;
    }

    /*
     * from the left to the right we are going to take each element of the passed array
     * and make a recursive using all the remaining elements as new array for the next call.
     */
    for( $index = 0 ; $index < count( $arr ) ; $index ++ ){
        $cabeza = array_slice( $arr, $index, 1 );
        $resto = $arr;
        array_splice( $resto, $index, 1 );
        ejecutar_permutacion($resto, $funcion, array_merge( $cabecera, $cabeza ) );
    }

    
}