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
                        $this->assertEquals( ["C","A","B"], $elemento );
                        break;
                    case 5:
                        $this->assertEquals( ["A","C","B"], $elemento );
                        break;
                }
                $cual++;
            }
            );
        
        $comb->ejecutar();
        
        $this->assertEquals( 3*2*1, $cual );
        
    }

    function test_4(){
        $comb = new Combinatoria();
        $arr = [ "A", "B", "C", "D" ];
        $comb->set_array( $arr );
        $cual = 0;
        
        $comb->set_funcion(
            function( $elemento ) use ( & $cual ){
                echo $cual;
                var_export( $elemento );
                switch( $cual ){
                    case 0: // nada
                        $this->assertEquals( ["A","B", "C","D"], $elemento );
                        break;
                    case 1: // 01
                        $this->assertEquals( ["B","A","C","D"], $elemento );
                        break;
                    case 2: // 12
                        $this->assertEquals( ["B","C","A","D"], $elemento );
                        break;
                    case 3: // 01
                        $this->assertEquals( ["C","B","A","D"], $elemento );
                        break;
                    case 4: // 12
                        $this->assertEquals( ["C","A","B","D"], $elemento );
                        break;
                    case 5: // 01
                        $this->assertEquals( ["A","C","B","D"], $elemento );
                        break;
                    case 6: // 13
                        $this->assertEquals( ["D","C", "B","A"], $elemento );
                        break;
                    case 7: // 12
                        $this->assertEquals( ["D","B", "C","A"], $elemento );
                        break;
                    case 8: // 01
                        $this->assertEquals( ["B","D", "C","A"], $elemento );
                        break;
                    case 9: // 12
                        $this->assertEquals( ["B","C", "D","A"], $elemento );
                        break;
                    case 10: // 01
                        $this->assertEquals( ["C","B", "D","A"], $elemento );
                        break;
                    case 11: // 12
                        $this->assertEquals( ["C","D", "B","A"], $elemento );
                        break;
                    case 12: // 23
                        $this->assertEquals( ["D","C", "B","A"], $elemento );
                        break;
                    case 13: // 
                        $this->assertEquals( ["D","C", "A","B"], $elemento );
                        break;
                    case 14: //
                        $this->assertEquals( ["D","A", "C","B"], $elemento );
                        break;
                    case 15: //
                        $this->assertEquals( ["A","D", "C","B"], $elemento );
                        break;
                    case 16: //
                        $this->assertEquals( ["A","C", "D","B"], $elemento );
                        break;
                    case 17: //
                        $this->assertEquals( ["C","A", "D","B"], $elemento );
                        break;
                    case 18: //
                        $this->assertEquals( ["C","D", "A","B"], $elemento );
                        break;
                }
                $cual++;
            }
            );
        
        $comb->ejecutar();
        
//         $this->assertEquals( 4*3*2*1, $cual );
        
    }
    
}
