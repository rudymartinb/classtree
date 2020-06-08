<?php
namespace tree;
/* 
 * I need a class to hold the info of just one tree of classes
 * I dont care if it just hold one class only
 * 
 * main objective: avoid having to walk into an array of arrays
 */
class tree {
	private $data;
	function __construct( Array $data_tree ){
		$this->data = $data_tree;
	}
	function get_width(){
		return count( $this->data );
	}
	
}