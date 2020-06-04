<?php
namespace diagram;
interface component {
	function get_width() : int;
	function get_height() : int;
	function set_xy( int $x, int $y );
}


// this hack is just to force Eclipse IDE to recognize the propper type
function force_component( component $component ) : \diagram\component {
	return $component;
}

class vertical_layout {
	private $margin_all;
	function set_margin( int $margin ){
		$this->margin_all = $margin;
	}
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
		return $height + ( $this->margin_all * 2 );
	}
	
	function get_max_width() : int {
		$max_width = 0;
		foreach( $this->components as $component ){
			$component = force_component($component);
			$width = $component->get_width();
			if( $width > $max_width ){
				$max_width = $width;	
			}
		}
		return $max_width + ( $this->margin_all * 2 );
	}
}