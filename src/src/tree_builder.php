<?php
namespace src;

abstract class tree_builder {
	protected $tree = [];
	
	function get_max_width(): int{
		return $this->max_width($this->tree);
	}
	function get_max_height(): int{
		return $this->tree[0]["height"];
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
	
	function resolve_class_hierarchy( string $parent = "" ) {
		$this->tree = $this->resolve();
	}
	
	abstract protected function resolve();
	abstract function add_source( string $source );
}