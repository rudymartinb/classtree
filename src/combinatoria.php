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
    
    
    function ejecutar2( Array $arr, Array $prefijo = [] ){
        $fact = count( $arr );
        
        $funcion = $this->funcion;

        for( $i = 0 ; $i < $fact  ; $i++ ){
            $funcion( $arr );
            $one = $i;
            $two = $i+1;
            $tmp = $arr[ $one ];
            $arr[ $one ] = $arr[ $two ];
            $arr[ $two ] = $tmp;
        }
            
    }
    function ejecutar( ){
        // as is ...
        $this->ejecutar2( $this->array );

       
    }
    
}