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

	
	function draw(){
		$this->maxwidth = $this->get_width() *2;
		$this->maxheight = $this->get_height() * 2;
		
		
		/* background color
		 */
		$this->color["white"] = imagecolorallocate($this->img, 255,   255,  255);
		$this->color["black"] = imagecolorallocate($this->img, 0,   0,  0);
		$this->color["gray" ] = imagecolorallocate($this->img, 240,   240,  240);
		
		/* canvas
		 */
		$this->img = imagecreatetruecolor( $this->maxwidth  , $this->maxheight );
		imagefilledrectangle( $this->img, 0,0,$this->maxwidth-1, $this->maxheight-1, $this->color["white"]);
		imageantialias ( $this->img, true );
		
		$this->class_tree->draw( $this->img );
		
		\imagepng($this->img,"/var/www/htdocs/salida.png");
		
	}
	
	
	
}