<?php

use src\function_;

function get_mod( string $source ){
    $pos = strpos($source, "$");
    
    // dollar sign must be present 
    if( $pos == 0 ){
        return "";    
    }
    return $source;
    
}

class function_Test extends PHPUnit\Framework\TestCase {
    function test_get_mod1(){
        $mod = get_mod( "" );
        $this->assertEquals( "", $mod );
    }
    function test_get_mod2(){
        $string1 = '$uno';
        $mod = get_mod( $string1  );
        $this->assertEquals( "", $mod );
    }
    
    
//     function test_get_mod1(){
//         $string1 = 'int $uno';
//         $arr = explode( "$", $string1 );
//         $mod = get_mod( $string1 );
//         $var = get_var( $string1 );
//         $this->assertEquals( "int ", $mod );
//         $this->assertEquals( '$uno', $var );
//     }
    
    
//     function test_1(){
//         $source = 'private function algo1( int $uno, string $dos ): string {';
//         $fn = new function_( $source );
//         $this->assertEquals( "algo1", $fn->get_name() );
//         $this->assertEquals( 'int $uno', $fn->get_params()[0] );
        
        
//     }
}

