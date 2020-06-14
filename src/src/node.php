<?php
namespace scr;


use diagram\vertical_layout;

/* 
 * I need a class to hold the info of just one node of classes
 * I dont care if it just hold one class only
 * 
 * main objective: avoid having to walk into an array of arrays
 */

function force_tree( node $tree ) : node {
	return $tree;
}
class node {
	private $name = "";
	private $children = [];
	private $width = 0;
	private $height = 0;
	function __construct( string $name ){
		$this->name = $name;
	}
	
	function get_name(): string {
		return $this->name;
	}

	
	function set_height(int $height) {
		$this->height = $height;
	}
	function get_height(): int {
		return $this->height;
	}
	function set_width( int $width ) {
		$this->width = $width;
	}
	function get_width() : int {
		return $this->width;
	}
	
	function set_namespace( string $name) {
	}
	function get_namespace(): string {
	}
	
	private $extends;
	function set_extends(string $extends) {
		$this->extends = $extends;
	}
	function get_extends(): string {
		return $this->extends;
	}

	private $implements;
	function set_implements(string $implements) {
		$this->implements = $implements;
	}
	function get_implements(): string {
		return $this->implements;
	}
	
	
	function set_children( Array $tree ) {
		$this->children = $tree;
	}
	function get_children(): Array {
		return $this->children;
	}


	/*
	 * these relative coordinates reffers to a virtual grid from X,Y 
	 * where 0,0 would be the upper left corner of the screen.
	 * the idea is to multiply these values per the maximum height and width of all elements
	 * plus some extra space among them (50% of height, 100% width)
	 * to make sure they don't overlap
	 * 
	 * that will give us the propper coordinates of the screen. 
	 */
	private $relcol;
	function set_relcol( int $relcol ) {
		$this->relcol = $relcol;
	}
	function get_relcol(): int {
		return $this->relcol;
	}

	
	private $relrow;
	function set_relrow( int $relrow ) {
		$this->relrow = $relrow;
	}
	function get_relrow(): int {
		return $this->relrow;
	}

	private $layout ;
	function do_layout() {
		
		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->add_text( $this->get_name() );
		$layout->do_layout();
		$layout->set_xy( $layout->get_max_width() /2, $layout->get_max_height() /2 );
		$layout->do_layout();
		
		$this->layout = $layout;
	}
	function get_layout() : vertical_layout {
		return $this->layout;
	}
	
	
}