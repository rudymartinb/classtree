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
    
    private function swap( $one, $two ){
        $tmp = $this->array[ $one ];
        $this->array[ $one ] = $this->array[ $two ];
        $this->array[ $two ] = $tmp;
    }
    
    function swap01( Callable $funcion ) {
        $this->swap( 0, 1 );
        $funcion( $this->array );
    }
    function ejecutar( ){
        $funcion = $this->funcion;

        $funcion( $this->array );
        
        if( count( $this->array ) == 1 ){
            return;
        }
        
        $this->swap01( $funcion ); 
        if( count( $this->array ) == 2 ){
            return;
        }
        
        $this->swap( 1, 2 );
        $funcion( $this->array );

        $this->swap( 0, 1 );
        $funcion( $this->array );
        

        $this->swap( 1, 2 );
        $funcion( $this->array );
        
        $this->swap( 0, 1 );
        $funcion( $this->array );
        
    }
}