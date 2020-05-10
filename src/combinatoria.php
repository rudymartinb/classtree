<?php

/* extract the second item and place it as first
 * then concatenates the rest of the array
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
function generar_permutaciones( Array $arr = null, Array $cabecera = [] ) : Array {
    if( is_null( $arr ) or count( $arr ) < 2 ){
        return [ $arr ];
    }

    if( count( $arr ) == 2 ){
        $resultado = [];
        $resultado[] = array_merge( $cabecera, $arr );
        $resultado[] = array_merge( $cabecera, permutacion( $arr, 1 ) );
        return $resultado ;
    }
    if( count( $arr ) >= 3 ){
        $resultado = [];

        for( $index = 0 ; $index < count( $arr ) ; $index ++ ){
            $cabeza = array_slice( $arr, $index, 1 );
            $resto = $arr;
            array_splice( $resto, $index, 1 );
            $partes = generar_permutaciones( $resto, array_merge( $cabecera, $cabeza ) );
            
            foreach( $partes as $value ){
                $resultado[] = $value ; // array_merge( $cabeza, $value );
            }
        }
        
    }
    return $resultado;
}