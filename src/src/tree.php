<?php
namespace tree;

// interface tree_interface {
// 	function set_name( string $name );
// 	function set_namespace( string $name );
// 	function set_children( Array $tree );
// 	function set_width( int $width ) ;
// 	function set_height( int $height );
	
// 	function get_name(): string;
// 	function get_children(): Array;
// 	function get_width(): int;
// 	function get_height(): int;
// }

/* 
 * I need a class to hold the info of just one tree of classes
 * I dont care if it just hold one class only
 * 
 * main objective: avoid having to walk into an array of arrays
 */
class tree {
	private $data;
	private $name;
	private $children;
	private $width;
	private $height;
	function __construct( string $name ){
		$this->name = $name;
	}
	function get_width() : int {
		return count( $this->data );
	}
	function set_width( int $width ) {
	}
	
	function set_name(string $name) {
	}
	function get_name(): string {
	}
	
	function set_namespace(string $name) {
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
	
	function set_children(array $tree) {
	}
	function get_children(): array {
	}

	function set_height(int $height) {
	}
	function get_height(): int {
	}

	
}