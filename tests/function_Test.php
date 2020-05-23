<?php

use src\function_;

class function_Test extends PHPUnit\Framework\TestCase {
    function test_1(){
        $source = 'private function algo1( int $uno, string $dos ): string {';
        $fn = new function_( $source );
        $this->assertEquals( "algo1", $fn->get_name() );
        $this->assertEquals( 'int $uno', $fn->get_params()[0] );
        
        
    }
}

