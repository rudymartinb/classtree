<?php
namespace diagram;
interface component {
	function get_width() : int;
	function get_height() : int;
}

class VerticalLayout {
	
	private $components = [];
	function add( component $component ){
		$this->components[] = $component;
	}
	function get_num_components() : int {
		return count( $this->components );
	}
}