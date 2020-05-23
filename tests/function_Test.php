<?php

use src\function_;
use src\parameter_;


class function_Test extends PHPUnit\Framework\TestCase {
    function test_get_mod1(){
        $param = new parameter_("");
        $this->assertEquals( "", $param->get_type()  );
    }
    function test_get_mod2(){
        $source = '$uno';
        $param = new parameter_( $source );
        $this->assertEquals( "", $param->get_type()  );
    }
    function test_get_mod3(){
        $source = 'int $uno';
        $param = new parameter_( $source );
        $this->assertEquals( "int", $param->get_type()  );
    }

    function test_get_var1(){
        $param = new parameter_("");
        $this->assertEquals( "", $param->get_name()  );
    }

    function test_get_var2(){
        $param = new parameter_("asdf");
        $this->assertEquals( "", $param->get_name()  );
    }

    function test_get_var3(){
        $param = new parameter_('$asdfasdf');
        $this->assertEquals( '$asdfasdf', $param->get_name()  );
    }
    
    
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

