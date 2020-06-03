<?php
namespace diagram;
interface component {
	function get_width() : int;
	function get_height() : int;
}
function force_component( component $component ) : \diagram\component {
	return $component;
}

class VerticalLayout {
	
	private $components = [];
	function add( component $component ){
		$this->components[] = $component;
	}
	function get_num_components() : int {
		return count( $this->components );
	}
	
	function get_max_height() : int {
		$height = 0;
		foreach( $this->components as $component ){
			$component = force_component($component);
			$height += $component->get_height();
		}
		return $height + 10;
	}
}