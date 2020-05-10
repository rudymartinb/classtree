<?php

//         $expected = [];

//         $expected[] = [ "A", "B", "C" ]; // given
//         $expected[] = [ "B", "A", "C" ]; // swap 0 to 1
//         $expected[] = [ "C", "A", "B" ]; // swap 1 2
//         $expected[] = [ "C", "B", "A" ]; // swap 0 1
//         $expected[] = [ "B", "C", "A" ]; // swap 1 2
//         $expected[] = [ "A", "C", "B" ]; // swap 0 1


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



function arr_to_str( Array $arr ) : string {
    $str = "";
    foreach( $arr  as $value ){
        $str .= $value;
    }
    return $str;
}

class combinatoriaTest extends PHPUnit\Framework\TestCase {
    
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
    
    function test_permutacion() {
        $arr = [ "A", "B", "C" ];
        
        $ini = 1; // second element
        $resultado = permutacion($arr, $ini);
        
        $this->assertEquals( ["B","A","C"], $resultado, "resultado final" );
        
    }
    
}
