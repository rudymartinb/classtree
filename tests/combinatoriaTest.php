<?php


class combinatoriaTest extends PHPUnit\Framework\TestCase {

    function test_permutacion_0() {
        $arr = [  ];
        $ini = 1; // second element
        $resultado = permutate($arr, $ini);
        $this->assertEquals( [], $resultado, "resultado final" );
    }

    function test_permutacion_1() {
        $arr = [ "A"];
        $ini = 1; // second element
        $resultado = permutate($arr, $ini);
        $this->assertEquals( ["A"], $resultado, "resultado final" );
    }
    
    function test_permutacion_2() {
        $arr = [ "A", "B" ];
        $ini = 1; // second element
        $resultado = permutate($arr, $ini);
        $this->assertEquals( ["B","A" ], $resultado, "resultado final" );
    }
    
    
    function test_permutacion_3() {
        $arr = [ "A", "B", "C" ];
        
        $ini = 1; // second element
        $resultado = permutate($arr, $ini);
        
        $this->assertEquals( ["B","A","C"], $resultado, "resultado final" );
    }

    function test_permutacion_3_2() {
        $arr = [ "A", "B", "C" ];
        
        $ini = 2; // third element
        $resultado = permutate( $arr, $ini);
        
        $this->assertEquals( ["C","A","B"], $resultado, "resultado final" );
    }


    function test_ejecutar_permutacion_0(){
        $arr = [];
        $expected = [];
        $expected[] = [];
        $pos = 0;
        $funcion = function( Array $actual ) use( $expected, &$pos ) {
            $this->assertEquals( $expected[ $pos ], $actual, "evaluando key ".$pos );
            $pos ++;
        };
        
        exceute_permutation($arr, $funcion);
        
        $this->assertEquals( 1, $pos);
    }

    function test_ejecutar_permutacion_1(){
        $arr = [ "0" ];
        $expected = [];
        $expected[] = [ "0" ];
        
        $pos = 0;
        // this is going to be executed twice ...
        $funcion = function( Array $actual ) use( $expected, &$pos ) {
            $this->assertEquals( $expected[ $pos ], $actual, "evaluando key ".$pos );
            $pos ++;
        };
        
        exceute_permutation($arr, $funcion);
        
        $this->assertEquals( 1, $pos);
    }
    
    function test_ejecutar_permutacion_2(){
        $arr = [ "0", "1" ];
        $expected = [];
        $expected[] = [ "0", "1" ];
        $expected[] = [ "1", "0" ];
        
        $pos = 0;
        // this is going to be executed twice ...
        $funcion = function( Array $actual ) use( $expected, &$pos ) {
            $this->assertEquals( $expected[ $pos ], $actual, "evaluando key ".$pos );
            $pos ++;
        };
        
        exceute_permutation($arr, $funcion);
        
        $this->assertEquals( 2, $pos);
    }

    function test_ejecutar_permutacion_3(){
        $arr = [ "A", "B", "C" ];
        $expected = [];
        
        $expected[ ] = [ "A", "B", "C" ];
        $expected[ ] = [ "A", "C", "B" ];
        $expected[ ] = [ "B", "A", "C" ];
        $expected[ ] = [ "B", "C", "A" ];
        $expected[ ] = [ "C", "A", "B" ];
        $expected[ ] = [ "C", "B", "A" ];
        
        $pos = 0;
        
        // this is going to be executed 6 times ...
        $funcion = function( Array $actual ) use( $expected, &$pos ) {
            $this->assertEquals( $expected[ $pos ], $actual, "evaluando key ".$pos );
            $pos ++;
        };
        
        exceute_permutation($arr, $funcion);
    }

    function test_ejecutar_permutacion_4(){
        $arr = [ "A", "B", "C", "D" ];
        $expected = [];
        $expected[] = [ "A", "B", "C", "D" ];
        $expected[] = [ "A", "B", "D", "C" ];
        $expected[] = [ "A", "C", "B", "D" ];
        $expected[] = [ "A", "C", "D", "B" ];
        $expected[] = [ "A", "D", "B", "C" ];
        $expected[] = [ "A", "D", "C", "B" ];
        
        $expected[] = [ "B", "A", "C", "D" ];
        $expected[] = [ "B", "A", "D", "C" ];
        $expected[] = [ "B", "C", "A", "D" ];
        $expected[] = [ "B", "C", "D", "A" ];
        $expected[] = [ "B", "D", "A", "C" ];
        $expected[] = [ "B", "D", "C", "A" ];
        
        $expected[] = [ "C", "A", "B", "D" ];
        $expected[] = [ "C", "A", "D", "B" ];
        $expected[] = [ "C", "B", "A", "D" ];
        $expected[] = [ "C", "B", "D", "A" ];
        $expected[] = [ "C", "D", "A", "B" ];
        $expected[] = [ "C", "D", "B", "A" ];
        
        $expected[] = [ "D", "A", "B", "C" ];
        $expected[] = [ "D", "A", "C", "B" ];
        $expected[] = [ "D", "B", "A", "C" ];
        $expected[] = [ "D", "B", "C", "A" ];
        $expected[] = [ "D", "C", "A", "B" ];
        $expected[] = [ "D", "C", "B", "A" ];
        
        $pos = 0;
        
        // this is going to be executed 6 times ...
        $funcion = function( Array $actual ) use( $expected, &$pos ) {
            $this->assertEquals( $expected[ $pos ], $actual, "evaluando key ".$pos );
            $pos ++;
        };
        
        exceute_permutation($arr, $funcion);
        
        $this->assertEquals(24, $pos);
        
    }

    // uncomment if you want to test any number of permutations
    // and see how fast php can be
    
//     function test_ejecutar_permutacion_10(){
//         $arr = [ ];
//         for( $i = 0 ; $i < 10; $i++){
//             $arr[] = $i;
//         }
//         $pos = 0;
        
//         // this is going to be executed 6 times ...
//         $funcion = function( Array $actual ) use( &$pos ) {
//             $pos ++;
//         };
        
//         ejecutar_permutacion($arr, $funcion);
//         $this->assertEquals( 10*9*8*7*6*5*4*3*2, $pos);
//     }

    
    // a few micro tests
    
    /* just to be on the safe side ...
     */
    function test_array_merge() {
        $arr1 = [];
        $arr2 = ["A","B"];
        
        $result = array_merge( $arr1, $arr2 );
        $this->assertEquals( [ "A","B"], $result );
        
    }
    
    /*
     * the most basic opeartion we can do
     * take out one item from the array
     * and create a new one ordered
     */
     function test_splice() {
         $arr = [ "A", "B", "C" ];
         
         $resto = $arr;
         $cabeza = array_splice( $resto, 1,1 );
         
         $this->assertEquals( ["B"], $cabeza, "cabeza = parte que nos interesa de la izquierda" );
         $this->assertEquals( ["A","C"], $resto, "resto = parte derecha a permutar" );
         
         $this->assertEquals( ["A","B","C"], $arr, "array original debe estar intacto" );
         
         $resultado = array_merge( $cabeza , $resto );
         $this->assertEquals( ["B","A","C"], $resultado, "resultado final" );
     }
     
    
}
