<?php

use src\parameters_finder;

class parameters_finder_Test extends PHPUnit\Framework\TestCase {
    
    function test_get_mod1(){
        $param = new parameters_finder("");
        $this->assertEquals( false, $param->more_elements()  );
    }
    function test_get_mod2(){
        $source = '$uno';
        $param = new parameters_finder( $source );
        $this->assertEquals( true, $param->more_elements()  );
        $this->assertEquals( "", $param->get_type()  );
    }
    function test_get_mod3(){
        $source = 'int $uno';
        $param = new parameters_finder( $source );
        $this->assertEquals( true, $param->more_elements()  );
        $this->assertEquals( "int", $param->get_type()  );
    }
    
    function test_get_var2(){
    	$param = new parameters_finder("asdf");
    	$this->assertEquals( false, $param->more_elements()  );
    }
    
    function test_get_var3(){
    	$param = new parameters_finder('$asdfasdf');
    	$this->assertEquals( true, $param->more_elements()  );
        $this->assertEquals( 'asdfasdf', $param->get_name()  );
    }

    function test_2_params(){
    	$param = new parameters_finder('int $uno, string $dos');
    	$this->assertEquals( true, $param->more_elements()  );
    	$this->assertEquals( 'int', $param->get_type()  );
    	$this->assertEquals( 'uno', $param->get_name()  );
    	$param->next();
    	$this->assertEquals( 'string', $param->get_type()  );
    	$this->assertEquals( 'dos', $param->get_name()  );
    }
    
    
}

