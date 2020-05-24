<?php

use src\namespace_finder;

class namespace_finder_Test extends PHPUnit\Framework\TestCase {
	function test1(){
		
		$source = '
<?php
namespace something;

function body() {
	$head=1;
}
';
		
		$finder = new namespace_finder();
		
		$matches = $finder->matches( $source );
		$bodies = $finder->find_bodies();
		$namespaces = $finder->split();
		
		//
		//         var_dump($matches);
		
		$class = $classes[0]; // sarasa interface
		
		$expected = '
    function algo() : string;
    function algo1( string $something ) : string;
    function algo2( father $father ) : string;
}
';
		$this->assertEquals( $expected, $bodies["sarasa_interface"] );
		$this->assertEquals( "sarasa_interface", $class->get_name() );
		$this->assertEquals( $expected, $class->get_body() );
		
	}
    
}

