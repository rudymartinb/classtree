<?php
function arr_to_str( Array $arr ) : string {
    $str = "";
    foreach( $arr  as $value ){
        $str .= $value;
    }
    return $str;
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
    
    private function swap( $one, $two, Callable $funcion  ){
        $tmp = $this->array[ $one ];
        $this->array[ $one ] = $this->array[ $two ];
        $this->array[ $two ] = $tmp;
        
        $funcion( $this->array );
    }
    
    private function swap01( Callable $funcion ) {
        $this->swap( 0, 1, $funcion );
        
    }
    private function swap12( Callable $funcion ) {
        $this->swap( 1, 2, $funcion  );
    }

    private function swap120( Callable $funcion ) {
        $this->swap01( $funcion );
        if( count( $this->array ) == 2 ){
            return;
        }
        $this->swap12( $funcion );
        $this->swap01( $funcion );
        $this->swap12( $funcion );
        $this->swap01( $funcion );
        
    }
    
    function ejecutar( ){
        $funcion = $this->funcion;

        // as is ...
        $funcion( $this->array );
        if( count( $this->array ) == 1 ){
            return;
        }
        
        $this->swap120( $funcion );

        
        if( count( $this->array ) <= 3 ){
            return;
        }
        
        // 5
        $this->swap( 2, 3, $funcion );
         
        $this->swap120( $funcion );

        $this->swap( 2, 3, $funcion );


        $this->swap120( $funcion );

        $this->swap( 0, 3, $funcion );

        
        $this->swap120( $funcion );
        
//         $funcion( $this->array );
        
//         $funcion( $this->array );
        
//         $this->swap120( $funcion );
//         $this->swap120( $funcion );
        
        
    }
}