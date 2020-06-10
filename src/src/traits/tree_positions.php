<?php
namespace src;
use function tree\force_tree;
use tree\tree;

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
	
	
	private function get_relative_column2( string $classname, Array $trees ) : int {
		return $this->scan_tree( $classname, $trees,
				function( tree $tree ){
					return $tree->get_relcol();
				} );
	}
	
	
	private function get_relative_inner_column2( string $classname, Array $trees ) : float {
		return $this->scan_tree( $classname, $trees,
				function( tree $tree ){
					return $tree->get_relcol()+(($tree->get_width()-1)/2);
				} );
	}
	
	private function get_relative_row2( string $classname, Array $trees ) : int {
		return $this->scan_tree( $classname, $trees,
				function( tree $tree ){
					return $tree->get_relrow();
				} );
	}
	
	private function scan_tree( $classname, Array $trees, Callable $return ) : float {
		foreach( $trees as $tree ){
			if( $tree->get_name() == $classname ){
				return $return( $tree );
			}
			$ret = $this->scan_tree( $classname, $tree->get_children(), $return );
			if( $ret != -1 ){
				return $ret;
			}
		}
		// classname not found
		return -1;
		
	}
	
}
