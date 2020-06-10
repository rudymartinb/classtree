<?php
namespace src;
use function tree\force_tree;

trait tree_positions {
	
	private function max_width( Array $trees ) : int {
		$actual = 0;
		foreach( $trees as $tree ){
			$actual += $tree->get_width();
		}
		return $actual;
	}
	
	private function max_height( Array $trees ) : int {
		$maxheight = 0;
		foreach( $trees as $tree ){
			$tree = force_tree( $tree );
			$actual = $tree->get_height();
			if( $actual > $maxheight ){
				$maxheight = $actual;
			}
		}
		return $maxheight;
	}
	
}
