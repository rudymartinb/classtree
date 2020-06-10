<?php
namespace tree;


/* 
 * I need a class to hold the info of just one tree of classes
 * I dont care if it just hold one class only
 * 
 * main objective: avoid having to walk into an array of arrays
 */

function force_tree( tree $tree ) : tree {
	return $tree;
}
class tree {
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
	
	function set_children( Array $tree ) {
		$this->children = $tree;
	}
	function get_children(): Array {
		return $this->children;
	}

	function set_height(int $height) {
		$this->height = $height;
	}
	function get_height(): int {
		return $this->height;
	}

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
	
	
}