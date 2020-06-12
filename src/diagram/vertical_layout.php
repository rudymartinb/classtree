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
function force_component( component $component ) : component {
	return $component;
}

class vertical_layout {
	private $margin_all = 4;
	function set_margin( int $margin ){
		$this->margin_all = $margin;
	}
	private $components = [];
	function add( component $component ){
		$this->components[] = $component;
	}
	function add_text( string $text ){
		$dt = new draw_text($text);
		$this->add($dt);
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

	private $internal_margin = 3;
	private $layout_done = false;
	function do_layout() {
		$width = $this->get_max_width();
		$new_y = $this->y + $this->margin_all;
		foreach( $this->components as $component ){
			$new_y += $component->get_height() + $this->internal_margin;
			$component = force_component($component);
			$component->set_xy( $this->x+$this->margin_all, $new_y );
			$component->set_width($width);
// 			$new_y += $this->internal_margin;
		}
		$this->layout_done = true;
	}
	
	
	function draw( $img ) {
		
		if( !$this->layout_done ){
			$this->do_layout();
		}
		imagerectangle( $img, $this->x, $this->y, $this->maxwidth+$this->x, $this->maxheight+$this->y, $this->color["black"]);
		
		foreach( $this->components as $component ){
			$component = force_component($component);
			
			$component->draw($img);

		}
	}
	
	
	
	function get_max_height() : int {
		$height = $this->margin_all;
		foreach( $this->components as $component ){
			$component = force_component($component);
			$height += $component->get_height()+$this->internal_margin;
		}
		return $height + $this->margin_all;
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