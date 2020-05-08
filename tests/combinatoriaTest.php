<?php

class combinatoriaTest extends PHPUnit\Framework\TestCase {
    function test_1(){
        $comb = new Combinatoria();
        $arr = [ "A" ];
        $comb->set_array( $arr );
        $comb->set_funcion( function( $elemento ){
            $this->assertEquals( "A", $elemento[0] );
        });
        $comb->ejecutar();
    }
    
    function test_2(){
        $comb = new Combinatoria();
        $arr = [ "A", "B" ];
        $comb->set_array( $arr );
        $cual = 0;
        
        $comb->set_funcion( 
            function( $elemento ) use ( & $cual ){
                switch( $cual ){
                    case 0:
                        $this->assertEquals( ["A","B"], $elemento );
                        break;
                    case 1:
                        $this->assertEquals( ["B","A"], $elemento );
                        break;
                }
                $cual++;
            }
        );
        
        $comb->ejecutar();
        
        $this->assertEquals( 2, $cual );
        
    }
    
    /*
     * CBA 111
     * BCA 100 
     * CAB 101
     * ACB 011
     * BAC 010
     * ABC 001
     */

    function test_3(){
        $comb = new Combinatoria();
        $arr = [ "A", "B", "C" ];
        $comb->set_array( $arr );
        $cual = 0;
        
        $comb->set_funcion(
            function( $elemento ) use ( & $cual ){
                switch( $cual ){
                    case 0:
                        $this->assertEquals( ["A","B", "C"], $elemento );
                        break;
                    case 1:
                        $this->assertEquals( ["B","A","C"], $elemento );
                        break;
                    case 2:
                        $this->assertEquals( ["B","C","A"], $elemento );
                        
                        break;
                    case 3:
                        
                        $this->assertEquals( ["C","B","A"], $elemento );
                        break;
                    case 4:
                        $this->assertEquals( ["A","C","B"], $elemento );
                        break;
                    case 5:
                        $this->assertEquals( ["C","A","B"], $elemento );
                        break;
                }
                $cual++;
            }
            );
        
        $comb->ejecutar();
        
        $this->assertEquals( 3*2*1, $cual );
        
    }

//     function test_4(){
//         $comb = new Combinatoria();
//         $arr = [ "A", "B", "C", "D" ];
//         $comb->set_array( $arr );
//         $cual = 0;
        
//         $comb->set_funcion(
//             function( $elemento ) use ( & $cual ){
//                 switch( $cual ){
//                     case 0:
//                         $this->assertEquals( ["A","B", "C","D"], $elemento );
//                         break;
//                     case 1:
//                         $this->assertEquals( ["B","A","C","D"], $elemento );
//                         break;
//                     case 2:
//                         $this->assertEquals( ["A","C","B","D"], $elemento );
//                         break;
//                     case 3:
//                         $this->assertEquals( ["C","A","B","D"], $elemento );
//                         break;
//                     case 4:
//                         $this->assertEquals( ["B","C","A","D"], $elemento );
//                         break;
//                     case 5:
//                         $this->assertEquals( ["C","B","A","D"], $elemento );
//                         break;
//                 }
//                 $cual++;
//             }
//             );
        
//         $comb->ejecutar();
        
//         $this->assertEquals( 4*3*2*1, $cual );
        
//     }
    
}
