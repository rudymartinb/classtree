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
    if( count( $arr ) <= 1 ){
        $funcion( $arr );
        return;
    }
    
    if( count( $arr ) == 2 ){
        /* funcion is called twice 
         * because array has 2 elements
         */
        $funcion( array_merge( $cabecera, $arr ) );
        $funcion( array_merge( $cabecera, permutacion( $arr, 1 ) ) );
        return;
    }

    /*
     * from the left to the right we are going to take each element
     * and make a recursive all using the remaining as new array
     */
    for( $index = 0 ; $index < count( $arr ) ; $index ++ ){
        $cabeza = array_slice( $arr, $index, 1 );
        $resto = $arr;
        array_splice( $resto, $index, 1 );
        ejecutar_permutacion($resto, $funcion, array_merge( $cabecera, $cabeza ) );
    }

    
}