<?php

use src\function_;
use src\parameter_;


class function_Test extends PHPUnit\Framework\TestCase {
    
    function test_1(){
        $source = 'private function algo1( int $uno, string $dos ): string {';
        $fn = new function_( $source );
        $this->assertEquals( "algo1", $fn->get_name() );
        $this->assertEquals( 'int', $fn->get_params()[0]->get_type() );
        $this->assertEquals( '$uno', $fn->get_params()[0]->get_name() );
        $this->assertEquals( 'string', $fn->get_params()[1]->get_type() );
        $this->assertEquals( '$dos', $fn->get_params()[1]->get_name() );
        
        
    }
}

