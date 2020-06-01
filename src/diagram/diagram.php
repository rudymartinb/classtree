<?php
namespace diagram;
use src\class_finder;

class diagram {
	function get_num_elements() : int {
		return count( $this->elements );
	}
	
	private $elements = [];
	function add_source( string $source ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$element = new element();
			$element->set_name($finder->get_name());
			$element->set_namespace($finder->get_namespace());
			$this->elements[] = $element;
			$finder->next();
		}
	}
	
	function get_element_by_name( string $name ) : element {
		foreach( $this->elements as $element ){
			if( $element->get_name() === $name ){
				return $element;
			}
		}
		// this should throw an exception
		return null;
	}
	private $current_key = 0;
	function place(){
		$element = $this->elements[ $this->current_key ];
		$element->set_position( 0, 0 );
		
	}
	
	function draw(){
		
		
		$this->maxwidth = 1024;
		$this->maxheight = 768;
		
		$this->img = imagecreatetruecolor( $this->maxwidth, $this->maxheight);
		imageantialias ( $this->img, true );
		
		/* background color
		 */
		$this->color["white"] = imagecolorallocate($this->img, 255,   255,  255);
		
		/* boxes
		 */
		$this->color["black"] = imagecolorallocate($this->img, 0,   0,  0);
		
		$this->color["gray"]   = imagecolorallocate($this->img, 240,   240,  240);
		
		
		/* canvas
		 */
		imagefilledrectangle($this->img, 0,0,$this->maxwidth-1, $this->maxheight-1, $this->color["white"]);
		
	}
	
	/* TODO: calculate heigh based on the number of functions
	 */
	private function draw_class( string $name ){
		$x = 10;
		$y = 10;
		$width = 100;
		$height = 50;
		imagefilledrectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["white"] );
		imagerectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["black"] );
		
		
		$font = './fonts/courier.ttf';
		$font = realpath($font) ;
		$text = $name;
		\imagettftext($this->img, 10,0.0, $x+5, $y+15, $this->color["black"] , $font, $text);
	}
	
	
}