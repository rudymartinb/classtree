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
    
    private function swap( $one, $two  ){
        $funcion = $this->funcion;
        
        $tmp = $this->array[ $one ];
        $this->array[ $one ] = $this->array[ $two ];
        $this->array[ $two ] = $tmp;
        
        $funcion( $this->array );
    }
    
    private function swap01() {
        $this->swap( 0, 1 );
        
    }
    private function swap12() {
        $this->swap( 1, 2 );
    }

    private function swap120() {
        $this->swap01();
        if( count( $this->array ) == 2 ){
            return;
        }
        $this->swap12();
        $this->swap01();
        $this->swap12();
        $this->swap01();
        
    }
    
    function ejecutar2( Array $arr, Array $prefijo = [] ){
        $funcion = $this->funcion;
        $funcion( $arr );
        
        if( count( $arr ) == 1 ){
            return;
        }
//         foreach ($arr as $key => $value ){
            // separar el resto del array
            // en nuevo array
            
//             $arr2 = $arr;
            $one = 0;
            $two = 1;
            $tmp = $arr[ $one ];
            $arr[ $one ] = $arr[ $two ];
            $arr[ $two ] = $tmp;
            
            $funcion( $arr );
//         }
        
    }
    function ejecutar( ){
        // as is ...
        $this->ejecutar2( $this->array );

        
//         if( count( $this->array ) == 1 ){
//             return;
//         }
        
//         $this->swap120();
        
//         if( count( $this->array ) <= 3 ){
//             return;
//         }
        
//         // 5
//         $this->swap( 2, 3);
//         $this->swap120();

//         $this->swap( 2, 3 );
//         $this->swap120();

//         $this->swap( 0, 3);
//         $this->swap120();
        
    }
    
}