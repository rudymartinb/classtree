<?php
namespace diagram;

/*
 * element = class, interface or trait on a diagram
 * 
 * just an rectangle with some text
 * type should go first unless its a class
 * name (with modifiers like abstract/final?)
 * interfaces unless present on the diagram
 * extends unless present on the diagram
 * traits always for now.
 * list of functions names (at least for now)
 */
class element {
	use element_properties;
	
	private $placed = false;
	function get_height() : int {
		$total = $this->name_draw->get_height();
		return $total;
	}

	function is_placed() : bool{
		return $this->placed;
	}
	
	private $x, $y;
	function set_position( int $x, int $y ){
		$this->x = $x;
		$this->y = $y;
		$this->placed = true;
	}
	
	private $img;
	private $colors = [];
	function draw() {
		$testGD = get_extension_funcs("gd"); // Grab function list
		if (!$testGD){
			echo "GD not even installed.";
			return;
		}
		
		
		$this->maxwidth = 1024;
		$this->maxheight = 768;
		
		$this->img = imagecreatetruecolor( $this->maxwidth, $this->maxheight);
		
		$this->set_colors();
		imageantialias ( $this->img, true );
		
		\imagepng($this->img,"/var/www/htdocs/salida.png");
	}
	private function draw_class( string $name, Array $class ){
		$x = $this->x;
		$y = $this->y;
		$width = 100;
		$height = 50;
		imagefilledrectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["white"] );
		imagerectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["black"] );
		
		putenv('GDFONTPATH=' . realPath('fonts'));
		$font = './fonts/courier.ttf';
		$font = realpath($font) ;
		$text = $name ." ". $class["x"]." ".$class["y"];
		\imagettftext($this->img, 10,0.0, $x+5, $y+15, $this->color["black"] , $font, $text);
	}
	
	function set_colors(){
		/* background color
		 */
		$this->color["white"] = imagecolorallocate($this->img, 255,   255,  255);
		
		/* boxes
		 */
		$this->color["black"] = imagecolorallocate($this->img, 0,   0,  0);
		
		$this->color["gray"]   = imagecolorallocate($this->img, 240,   240,  240);
		
	}
	
}