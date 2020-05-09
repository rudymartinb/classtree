<?php

function comb( Array $arr ) : Array {
    if( count( $arr ) <= 1 ){
        return [ $arr ];
    }
    if( count( $arr ) == 2 ){
        $b = [ $arr[1], $arr[0] ];
        return [ $arr, $b ];
    }
    if( count( $arr ) == 3 ){
        $total = [];
        
        $total[] = [ $arr ];
        $copia = $arr;
//         var_dump( $copia );
        $cabeza = array_splice( $copia, 0, 1 );
//         var_dump( $copia );
        var_dump( $cabeza );
        $resto = array_slice( $copia, 0  );
//         var_dump( $copia );
        
        var_dump( $resto );
//         var_dump( $copia );
        
        $resultado = comb( $resto );
        
        var_dump( $resultado );
//         var_dump( $resultado[0] );
//         var_dump( $resultado[1] );
//         $total = array_merge($cabeza,$resultado);
        
        

//         for( $i = 0 ; $i <= count( $arr ) ; $i++ ){
//             $copia = $arr;
//             $cabeza = array_slice( $copia, $i, 1 );
//             $resto = array_splice( $copia, $i, 1 );
//             $resultado = comb( $resto );
            
            foreach( $resultado as $key => $value ){
                $resultado[ $key ] = array_merge( $cabeza , $value ) ;
            }
//             $total = array_merge( $total, $resultado );
//             vaR_dump( $total );
//         }
        
        
//         $resultado = array_merge( [ $arr ], $resultado );
//         var_dump($resultado);
        return $resultado;
    }
}

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