<?php


use src\usetrait_finder;

class usetrait_finder_Test extends PHPUnit\Framework\TestCase {
	function test_empty(){
		$finder = new usetrait_finder("");
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_somethingelse(){
		$finder = new usetrait_finder("asdfasdf");
		$this->assertEquals( false, $finder->more_elements() );
	}

	function test_basic(){
		$finder = new usetrait_finder("use sometrait;");
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "sometrait", $finder->get_trait_name() );
	}

	function test_basic_2(){
		$source = "use sometrait;
use someothertrait;";
		
		$finder = new usetrait_finder( $source );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "sometrait", $finder->get_trait_name() );
		$finder->next();
		$this->assertEquals( "someothertrait", $finder->get_trait_name() );
		
	}

	function test_basic_2_on_1_line(){
		$source = "use sometrait , someothertrait;";
		
		$finder = new usetrait_finder( $source );
// 		var_dump( $finder->matches($source)["traitname"] );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "sometrait", $finder->get_trait_name() );
		$finder->next();
		$this->assertEquals( "someothertrait", $finder->get_trait_name() );
		
	}
	
	function test_basic_2_on_1_line_body(){
		$source = "use sometrait , someothertrait { anything }
function test() {}";
		
		$finder = new usetrait_finder( $source );
// 		var_dump( $finder->matches($source)["traitname"] );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "sometrait", $finder->get_trait_name() );
		$finder->next();
		$this->assertEquals( "someothertrait", $finder->get_trait_name() );
		
	}

	function test_weird(){
		$source = "use 
sometrait 
, 
someothertrait 
{ anything }
function test() {}";
		
		$finder = new usetrait_finder( $source );
// 		var_dump( $finder->matches($source)["traitname"] );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "sometrait", $finder->get_trait_name() );
		$finder->next();
		$this->assertEquals( "someothertrait", $finder->get_trait_name() );
		
	}

	
	function test_valid_source(){
		$source = "{ use
sometrait
,
someothertrait
{ anything }
function test() {}
}";
		
		$finder = new usetrait_finder( $source );
		// 		var_dump( $finder->matches($source)["traitname"] );
		
		$this->assertEquals( true, $finder->more_elements() );
		$this->assertEquals( "sometrait", $finder->get_trait_name() );
		$finder->next();
		$this->assertEquals( "someothertrait", $finder->get_trait_name() );
		
	}
	
	
}

