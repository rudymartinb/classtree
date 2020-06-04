<?php
namespace diagram;
interface component {
	function set_width( int $width );
	function get_width() : int;
	function get_height() : int;
	function set_xy( int $x, int $y );
	function get_x() : int;
	function get_y() : int;
	
	function set_draw_function( Callable $function );
	function draw( $img );
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
	
	private $x;
	private $y;
	function set_xy( int $x, int $y ){
		$this->x = $x;
		$this->y = $y;
	}

	private $layout_done = false;
	function do_layout() {
		$width = $this->get_max_width();
		$new_y = $this->y+$this->margin_all;
		foreach( $this->components as $component ){
			$component = force_component($component);
			$component->set_xy( $this->x+$this->margin_all, $new_y );
			$component->set_width($width);
			$new_y += $component->get_height();
		}
		$this->layout_done = true;
	}
	
	function draw( $img ) {
		
		if( !$this->layout_done ){
			$this->do_layout();
		}
		
		foreach( $this->components as $component ){
			$component = force_component($component);
			
			$component->draw($img);

		}
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