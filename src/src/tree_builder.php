<?php
namespace src;

abstract class tree_builder {
	protected $tree = [];
	
	function get_max_width(): int{
		return $this->max_width( $this->tree );
	}
	function get_max_height(): int{
		return $this->max_height( $this->tree );
	}
	
	protected function max_width( Array $trees ) : int {
		$actual = 0;
		foreach( $trees as $tree ){
			$actual += $tree["width"];
		}
		return $actual;
	}
	
	protected function max_height( Array $trees ) : int {
		$maxheight = 0;
		foreach( $trees as $tree ){
			$actual = $tree["height"];
			if( $actual > $maxheight ){
				$maxheight = $actual;
			}
		}
		return $maxheight;
	}
	
	function resolve_class_hierarchy() {
		$this->tree = $this->resolve();
	}
	
	abstract protected function resolve( string $parent = "" );
	abstract function add_source( string $source );
}