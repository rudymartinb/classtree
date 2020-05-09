<?php

class Combinatoria {
    private $array;
    function set_array( Array & $array ){
        $this->array = $array;
    }
    
    private $funcion;
    function set_funcion( Callable $funcion ){
        $this->funcion = $funcion;
    }
    
    
    function ejecutar2( Array $arr, Array $prefijo = [] ){
        $todo = $arr+$prefijo;
        $fact = count( $todo );
        
        $funcion = $this->funcion;

        for( $i = 0 ; $i < $fact  ; $i++ ){
            $funcion( $arr );
//             if( $fact > 2 ) {
//                 $cabeza = array_slice( $arr, 0, $i );
//                 $cola = array_slice( $arr, $i+1 );
//                 $this->ejecutar2( $cabeza, $cola );
//             }
            for( $j = $i+1; $j < $fact ; $j ++ ){
                $one = $i;
                $two = $j;
                $tmp = $arr[ $one ];
                $arr[ $one ] = $arr[ $two ];
                $arr[ $two ] = $tmp;
            }
                
        }
            
    }
    function ejecutar( ){
        // as is ...
        $this->ejecutar2( $this->array );

       
    }
    
}