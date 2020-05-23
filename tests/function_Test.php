<?php

use src\function_;


class parameter_ {
    private $type;
    function get_type() : string {
        return $this->type; 
    }
    
    private $name;
    function get_name() : string {
        return $this->name;
    }
    
    function __construct( string $source ){
        $this->type = $this->extract_mod( $source );
        $this->name = $this->get_var($source);
    }
    
    private function extract_mod( string $source ){
        $source = trim( $source );
        $pos = strpos($source, "$");
        
        // dollar sign must be present
        if( $pos === FALSE or $pos == 0){
            return "";
        }
        return substr($source,0, $pos-1);
        
    }
    
    function get_var( string $source ){
        $pos = strpos($source, "$");
        
        // dollar sign must be present
        if( $pos === FALSE ){
            return "";
        }
        return substr($source,$pos);
    }
    
}

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

