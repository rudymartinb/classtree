<?php
function arr_to_str( Array $arr ) : string {
    $str = "";
    foreach( $arr  as $value ){
        $str .= $value;
    }
    return $str;
}

class combinatoriaTest extends PHPUnit\Framework\TestCase {
    function test1() {
        $arr = [ "A" ];
        $actual = comb( $arr );
        $esperado = [];
        $esperado[] = [ "A" ];
        $this->assertEquals( $esperado, $actual );
    }

    function test2() {
        
        $arr = [ "A", "B" ];
        $esperado = [];
        $esperado[] = [ "A", "B" ];
        $esperado[] = [ "B", "A" ];
//         var_dump( $esperado );
        $actual = comb( $arr );
        $this->assertEquals( $esperado, $actual );
    }
    function test_splice() {
        $copia  = [ "A", "B", "C" ];
        $cabeza = array_splice( $copia, 0 );
//         $resto = array_splice( $copia, 0, 1 );
        vaR_dump( $cabeza );
//         vaR_dump( $copia );
    }
    
//     function test_3(){
//         $arr = [ "A", "B", "C" ];
//         $esperado = [];
//         $esperado[] = [ "A", "B", "C" ]; // given
//         $esperado[] = [ "A", "C", "B" ]; // swap 0 1
//         $esperado[] = [ "B", "A", "C" ]; // swap 0 to 1
//         //         $esperado[] = [ "B", "C", "A" ]; // swap 1 2
//         //         $esperado[] = [ "C", "A", "B" ]; // swap 1 2
//         //         $esperado[] = [ "C", "B", "A" ]; // swap 0 1
        
//         $actual = comb( $arr );
//         $this->assertEquals( $esperado, $actual );
//     }
    

//     function test_1(){
//         $comb = new Combinatoria();
//         $arr = [ "A" ];
//         $comb->set_array( $arr );
//         $comb->set_funcion( function( $elemento ){
//             $this->assertEquals( "A", $elemento[0] );
//         });
//         $comb->ejecutar();
//     }
    
//     function test_2(){
//         $comb = new Combinatoria();
//         $arr = [ "A", "B" ];
//         $comb->set_array( $arr );
//         $cual = 0;
        
//         $cual = 0;
//         $expected = [];
//         $expected[] = [ "A", "B" ]; // given
//         $expected[] = [ "B", "A" ]; // swap 0 to 1
              
        
//         $comb->set_funcion(
//             function( $elemento ) use ( & $cual, $expected ){
//                 // prevent errors on uncompleted $expected elements
//                 if( $cual >= count( $expected ) ){
//                     return;
//                 }
    
//                 $actual = arr_to_str( $elemento );
//                 echo $cual." ".$actual."\n";
//                 $esperado = arr_to_str( $expected[ $cual ] );

//                 $this->assertEquals( $expected[ $cual ], $elemento, "elemento ".$cual. " ->  ".$esperado." = ".$actual );

// //                 $esperado = arr_to_str( $expected[ $cual ] );
// //                 $actual = arr_to_str( $elemento );
                
// //                 $this->assertEquals( $expected[ $cual ], $elemento, "elemento ".$cual. " ->  ".$esperado." = ".$actual );
//                 $cual++;
//             }
//             );
        
//         $comb->ejecutar();
        
//         $this->assertEquals( 2, $cual );
        
//     }
    
//     function test_3(){
//         $comb = new Combinatoria();
//         $arr = [ "A", "B", "C" ];
//         $comb->set_array( $arr );
//         $cual = 0;
//         $expected = [];
        
//         $expected[] = [ "A", "B", "C" ]; // given
//         $expected[] = [ "B", "A", "C" ]; // swap 0 to 1
//         $expected[] = [ "C", "A", "B" ]; // swap 1 2
//         $expected[] = [ "C", "B", "A" ]; // swap 0 1
//         $expected[] = [ "B", "C", "A" ]; // swap 1 2
//         $expected[] = [ "A", "C", "B" ]; // swap 0 1
        
//         $comb->set_funcion(
//             function( $elemento ) use ( & $cual, $expected ){
//                 $esperado = arr_to_str( $expected[ $cual ] );
                
//                 $actual = arr_to_str( $elemento );
//                 echo $cual." ".$actual."\n";
                
                
//                 $this->assertEquals( $expected[ $cual ], $elemento, "elemento ".$cual. " ->  ".$esperado." = ".$actual );
//                 $cual++;
//             }
//             );
        
//         $comb->ejecutar();
        
//         $this->assertEquals( 3*2*1, $cual );
        
//     }

//     function test_4(){
//         $comb = new Combinatoria();
//         $arr = [ "A", "B", "C", "D" ];
//         $comb->set_array( $arr );
//         $cual = 0;

//         $expected = [];
//         $expected[ 0] = [ "A", "B", "C", "D" ]; // given
//         $expected[ 1] = [ "B", "A", "C", "D" ]; // swap 0 1
//         $expected[ 2] = [ "B", "C", "A", "D" ]; // swap 1 2
//         $expected[ 3] = [ "C", "B", "A", "D" ]; // swap 0 1
//         $expected[ 4] = [ "C", "A", "B", "D" ]; // swap 1 2
//         $expected[ 5] = [ "A", "C", "B", "D" ]; // swap 0 1
        
//         $expected[ 6] = [ "A", "C", "D", "B" ]; // swap 2 3
//         $expected[ 7] = [ "C", "A", "D", "B" ]; // swap 0 1
//         $expected[ 8] = [ "C", "D", "A", "B" ]; // swap 1 2
//         $expected[ 9] = [ "D", "C", "A", "B" ]; // swap 0 1
//         $expected[10] = [ "D", "A", "C", "B" ]; // swap 1 2
//         $expected[11] = [ "A", "D", "C", "B" ]; // swap 0 1

//         $expected[12] = [ "A", "D", "B", "C" ]; // swap 2 3
//         $expected[13] = [ "D", "A", "B", "C" ]; // swap 0 1
//         $expected[14] = [ "D", "B", "A", "C" ]; // swap 1 2
//         $expected[15] = [ "B", "D", "A", "C" ]; // swap 0 1
//         $expected[16] = [ "B", "A", "D", "C" ]; // swap 1 2
//         $expected[17] = [ "A", "B", "D", "C" ]; // swap 0 1
        
//         $expected[18] = [ "C", "B", "D", "A" ]; // swap 0 3
//         $expected[19] = [ "B", "C", "D", "A" ]; // swap 0 1
//         $expected[20] = [ "B", "D", "C", "A" ]; // swap 1 2
//         $expected[21] = [ "D", "B", "C", "A" ]; // swap 0 1
//         $expected[22] = [ "D", "C", "B", "A" ]; // swap 1 2
//         $expected[23] = [ "C", "D", "B", "A" ]; // swap 0 1
        
        
        
        
//         $comb->set_funcion(
//             function( $elemento ) use ( & $cual, $expected ){
//                 // prevent errors on uncompleted $expected elements
//                 if( $cual >= count( $expected ) ){
//                     return;
//                 }
                
//                 $actual = arr_to_str( $elemento );
//                 echo $cual." ".$actual."\n";
//                 $esperado = arr_to_str( $expected[ $cual ] );
                
//                 $this->assertEquals( $expected[ $cual ], $elemento, "elemento ".$cual. " ->  ".$esperado." = ".$actual );
//                 $cual++;
//             }
//             );
        
//         $comb->ejecutar();
        
        
//     }
    
}
