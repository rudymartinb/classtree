<?php

/* extract the second item and place it as first
 * then concatenates the rest of the array
 * 
 */
function permutate( Array $arr, int $ini ) : Array {
    $remaining = $arr;
    $head = array_splice( $remaining, $ini,1 );
    $resultado = array_merge( $head , $remaining );
    return $resultado;
}


function execute_permutation( Array $arr, Callable $function, Array $head = [] ) {
    // edge cases 
    if( count( $arr ) <= 1 ){
        $function( $arr );
        return;
    }
    
    if( count( $arr ) == 2 ){
        /* function is called twice 
         * because array has 2 elements
         */
        $function( array_merge( $head, $arr ) );
        $function( array_merge( $head, permutate( $arr, 1 ) ) );
        return;
    }

    /*
     * from the left to the right we are going to take each element of the passed array
     * and make a recursive call using all the remaining elements as new array for the next call.
     */
    for( $index = 0 ; $index < count( $arr ) ; $index ++ ){
        $new_head = array_slice( $arr, $index, 1 );
        $remaining = $arr;
        array_splice( $remaining, $index, 1 ); // here $remaining is passed by reference
        execute_permutation( $remaining, $function, array_merge( $head, $new_head ) );
    }

    
}