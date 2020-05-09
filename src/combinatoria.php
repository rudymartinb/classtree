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
    
    
    function ejecutar2( Array $arr ){
        $cant = count( $arr );
        
        $funcion = $this->funcion;

        for( $i = 0 ; $i < $cant ; $i++ ){
//             $izq = array_splice($arr, 0, 1);
//             $der = array_splice($arr, 1 );
//             if( )
            $funcion( $arr );
            for( $j = $i+1; $j < $cant ; $j ++ ){
                
                $one = $i;
                $two = $j;
                $tmp = $arr[ $one ];
                $arr[ $one ] = $arr[ $two ];
                $arr[ $two ] = $tmp;
                $funcion( $arr );
            }
//             $this->ejecutar( $arr );
                
        }
            
    }
    function ejecutar( ){
        // as is ...
        $this->ejecutar2( $this->array );

       
    }
    
}