<?php
namespace diagram;
use src\interface_finder;
use src\class_tree_builder;

class diagram {
	
	private $class_tree;
	function __construct(){
		$this->class_tree = new class_tree_builder();
	}
	function add_source( string $source ){
		
		$this->class_tree->add_source($source);
		
		
	}
	function get_width() : int {
		return $this->class_tree->get_max_width();
	}
	function get_height() : int {
		return $this->class_tree->get_max_height();
	}
	function resolve_hiearchy(){
		$this->class_tree->resolve_hierarchy();
	}
	
// 	function get_element_by_name( string $name ) : element {
// 		foreach( $this->elements as $element ){
// 			if( $element->get_name() === $name ){
// 				return $element;
// 			}
// 		}
// 		// this should throw an exception
// 		return null;
// 	}
// 	private $current_key = 0;
// 	function place(){
// 		$element = $this->elements[ $this->current_key ];
// 		$element->set_position( 0, 0 );
		
// 	}
	
	function draw(){
		
		$layout = new vertical_layout();
		$layout->set_margin(5);
		
		$layout->add_text( "something goes here" );
		
		$layout->do_layout();
		$this->assertEquals( 1, $layout->get_num_components() );
		// 		$this->assertEquals( 26, $layout->get_max_height() );
		// 		$this->assertEquals( 162, $layout->get_max_width() );
		$layout->set_xy( $layout->get_max_width() /2, $layout->get_max_height() /2 );
		
		$this->maxwidth = $layout->get_max_width() *2;
		$this->maxheight = $layout->get_max_height() * 2;
		$this->img = imagecreatetruecolor( $this->maxwidth  , $this->maxheight );
		
		/* background color
		 */
		$this->color["white"] = imagecolorallocate($this->img, 255,   255,  255);
		$this->color["black"] = imagecolorallocate($this->img, 0,   0,  0);
		$this->color["gray" ] = imagecolorallocate($this->img, 240,   240,  240);
		
		/* canvas
		 */
		imagefilledrectangle( $this->img, 0,0,$this->maxwidth-1, $this->maxheight-1, $this->color["white"]);
		
		imageantialias ( $this->img, true );
		
		$layout->do_layout();
		$layout->draw( $this->img );
		
		// 		$this->assertEquals( 25, $mytext->get_x() );
		// 		$this->assertEquals( 48, $mytext->get_y() );
		
		\imagepng($this->img,"/var/www/htdocs/salida.png");
		
// 		$this->maxwidth = $this->get_width();
// 		$this->maxheight = 768;
		
// 		$this->img = imagecreatetruecolor( $this->maxwidth, $this->maxheight);
// 		imageantialias ( $this->img, true );
		
// 		/* background color
// 		 */
// 		$this->color["white"] = imagecolorallocate($this->img, 255,   255,  255);
		
// 		/* boxes
// 		 */
// 		$this->color["black"] = imagecolorallocate($this->img, 0,   0,  0);
		
// 		$this->color["gray"]   = imagecolorallocate($this->img, 240,   240,  240);
		
		
// 		/* canvas
// 		 */
// 		imagefilledrectangle($this->img, 0,0,$this->maxwidth-1, $this->maxheight-1, $this->color["white"]);
		
	}
	
// 	/* TODO: calculate heigh based on the number of functions
// 	 */
// 	private function draw_class( string $name ){
// 		$x = 10;
// 		$y = 10;
// 		$width = 100;
// 		$height = 50;
// 		imagefilledrectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["white"] );
// 		imagerectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["black"] );
		
		
// 		$font = './fonts/courier.ttf';
// 		$font = realpath($font) ;
// 		$text = $name;
// 		\imagettftext($this->img, 10,0.0, $x+5, $y+15, $this->color["black"] , $font, $text);
// 	}
	
	
}