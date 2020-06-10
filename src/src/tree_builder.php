<?php
namespace src;

use tree\tree;
use function tree\force_tree;

abstract class tree_builder {
	private $tree = [];
	protected $collector;
	
	abstract function get_new_collector() : collector ;
	
	function get_max_width(): int{
		return $this->max_width( $this->tree );
	}
	function get_max_height(): int{
		return $this->max_height( $this->tree );
	}
	
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

	function get_relative_column( string $classname, Array $trees = null ) : int {
		return $this->get_relative_column2($classname, $this->tree );
	}

	function get_relative_row( string $classname, Array $trees = null ) : int {
		return $this->get_relative_row2($classname, $this->tree );
	}

	function get_relative_inner_column( string $classname, Array $trees = null ) : float {
		return $this->get_relative_inner_column2($classname, $this->tree );
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
	
// 	private $relative_pos_evaluated = false;
	
// 	private function evaluate_positions(){
// 		if( ! $this->relative_pos_evaluated ){
// 			$this->calculate_relative_positions( $this->tree );
// 			$this->relative_pos_evaluated = true;
// 		}
// 	}

	
	private function calculate_relative_positions( Array $trees, int $col_offset = 0, int $row_offset = 0 ){
		$actual_column = $col_offset;
		foreach( $trees as $tree ){
			$tree = force_tree( $tree );
			$this->calculate_relative_positions( $tree->get_children(), $actual_column, $row_offset+1 );
			$tree->set_relcol( $actual_column );
			$tree->set_relrow( $row_offset );
			$width = $tree->get_width();
			$actual_column += $width;
		}
	}
	
	
	function resolve_hierarchy() {
		$this->tree = $this->resolve();
		$this->calculate_relative_positions( $this->tree );
	}
	
	private function resolve( string $parent = "" ) {
		$tree = [];
		
		// by doing this we keep the internal pointer
		// separated on each recursive call.
		$collector = $this->get_new_collector();
		
		while( $collector->more_elements() ){
			
			$node_name = $collector->get_name();
			$extends = $collector->get_extends();
			
			if( $parent !== "" ){
				if( $extends != $parent ) {
					$collector->next();
					continue;
				}
			} else {
				if( $extends !== "" ){
					$collector->next();
					continue;
				}
			}
			$children = $this->resolve( $node_name );
			
			$node = new tree( $node_name );
			$node->set_extends($extends);
			$node->set_children($children);
			$node->set_width( max( $this->max_width( $children ), 1 ) );
			$node->set_height( $this->max_height( $children )+1 );
			$tree[] = $node;
			$collector->next();
		}
		return $tree;
	}
	
	function add_source(string $source) {
		$nsfinder = new namespace_finder($source);
		while($nsfinder->more()){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->collector->add_source( $body, $namespace );
			$nsfinder->next();
		}
	}
	
	
	
}