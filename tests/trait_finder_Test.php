<?php


class trait_finder_Test extends PHPUnit\Framework\TestCase {
	function test_nothing(){
		$source = "";
		$finder = new trait_finder($source);
	}
	
}