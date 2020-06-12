<?php
namespace src;

use diagram\vertical_layout;

class class_tree_builder extends tree_builder {
	
	function __construct(){
		$this->collector = new class_collector();
	}
	
	function get_new_collector() : collector {
		return new class_collector( $this->collector );
	}

	function draw() {

		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->add_text( "something goes here" );
		$layout->do_layout();
		$layout->set_xy( $layout->get_max_width() /2, $layout->get_max_height() /2 );
		$layout->do_layout();
		$layout->draw( $this->img );
		
	}
	
}
