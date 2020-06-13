<?php
namespace src;

use scr\node;
use function scr\force_tree;

trait node_positions {
	
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
				function( node $tree ){
					return $tree->get_relcol();
				} );
	}
	
	
	private function get_relative_inner_column2( string $classname, Array $trees ) : float {
		return $this->scan_tree( $classname, $trees,
				function( node $tree ){
					return $tree->get_relcol()+(($tree->get_width()-1)/2);
				} );
	}
	
	private function get_relative_row2( string $classname, Array $trees ) : int {
		return $this->scan_tree( $classname, $trees,
				function( node $tree ){
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
	
	function calculate_relative_positions( ){
		$this->calculate_relative_positions_2( $this->tree );
	}
	private function calculate_relative_positions_2( Array $trees, int $col_offset = 0, int $row_offset = 0 ){
		$actual_column = $col_offset;
		foreach( $trees as $node ){
			$node = force_tree( $node );
			$this->calculate_relative_positions_2( $node->get_children(), $actual_column, $row_offset+1 );
			$node->set_relcol( $actual_column );
			$node->set_relrow( $row_offset );
			$width = $node->get_width();
			$actual_column += $width;
		}
	}
	
	
}
