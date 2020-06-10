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
	
	private function calculate_rel_cols( Array $trees, int $offset = 0 ){
		$actual = $offset;
		foreach( $trees as $tree ){
			$this->calculate_rel_cols( $tree->get_children(), $actual );
			$tree->set_relcol( $actual );
			$width = $tree->get_width();
			$actual += $width;
		}
	}
	
	function get_relative_column( string $classname, Array $trees = null ) : int {
		$this->calculate_rel_cols( $this->tree );
		return $this->get_relative_column2($classname, $this->tree );
	}
	
	function get_relative_column2( string $classname, Array $trees ) : int {
		foreach( $trees as $tree ){
			if( $tree->get_name() == $classname ){
				return $tree->get_relcol();
			}
			$ret = $this->get_relative_column2($classname, $tree->get_children());
			if( $ret != -1 ){
				return $ret;
			}
		}
		return -1;
	}
	
	function resolve_hierarchy() {
		$this->tree = $this->resolve();
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