<?php

use src\parameter_;

class parameter_Test extends PHPUnit\Framework\TestCase {
    
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
    
    
}

