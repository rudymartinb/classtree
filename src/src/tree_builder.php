<?php
namespace src;

use scr\node;
use function scr\force_tree;
use diagram\vertical_layout;

abstract class tree_builder {
	use tree_positions;
	
	private $tree = [];
	protected $collector;
	
	abstract function get_new_collector() : collector ;
	
	function get_max_width(): int{
		return $this->max_width( $this->tree );
	}
	function get_max_height(): int{
		return $this->max_height( $this->tree );
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
			
			$node = new node( $node_name );
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
	
	function draw( $img ) {
		$this->img = $img;
		$this->draw_tree( $this->tree );

	}
	
	private function draw_tree( Array $trees ) {
		foreach( $trees as $tree ){
			$this->draw_node( $tree );
			$this->draw_tree( $tree->get_children() );
		}
	}
	private function draw_node( node $node ){
		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->add_text( $node->get_name() );
		$layout->do_layout();
		$layout->set_xy( $layout->get_max_width() /2, $layout->get_max_height() /2 );
		$layout->do_layout();
		$layout->draw( $this->img );
	}
	
	
	
	
}