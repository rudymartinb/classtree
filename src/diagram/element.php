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
		$total = $this->name_draw->get_height()+10;
		return $total;
	}
	function get_width() : int {
		$total = $this->name_draw->get_width()+10;
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
		$this->set_canvas();
		
		imageantialias ( $this->img, true );
		
		$this->draw_class();
		imagepng($this->img,"/var/www/htdocs/salida.png");
	}
	
	private $layout = [];
	function do_layout(){
		$vertical = [];
// 		if( $this->type != "class"){
// 			$this->type_draw = new draw_text( "<<".$this->type.">>" );
// 			$vertical[] = $this->type_draw;
// 		}
		
		$vertical[] = $this->name_draw;
		
		$this->layout = $vertical;
		
		/*
		 * x and y are just the starting point
		 * from the upper left corner.
		 * 
		 * now I need to figure out 
		 * how to place the components from the relative position.
		 */
		$width = $this->get_width()+10;
		$height = $this->get_height()+10;
		
		
	}
	
	
	private function draw_class( ){
		$x = $this->x;
		$y = $this->y;
		$width = $this->get_width()+10;
		$height = $this->get_height();
		imagefilledrectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["white"] );
		imagerectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["black"] );
		if( $this->type != "class" ){
			$this->draw_type();
		}
		$this->draw_class_name();
	}

	private function draw_type(){
		$x = $this->x;
		$y = $this->y;
		putenv('GDFONTPATH=' . realPath('fonts'));
		$font = './fonts/courier.ttf';
		$font = realpath($font) ;
		$text = "<<".$this->type.">>" ;
		\imagettftext($this->img, 10,0.0, $x+5, $y+15, $this->color["black"] , $font, $text);
	}
	
	private function draw_class_name(){
		$x = $this->x;
		$y = $this->y;
		putenv('GDFONTPATH=' . realPath('fonts'));
		$font = './fonts/courier.ttf';
		$font = realpath($font) ;
		$text = $this->name ;
		\imagettftext($this->img, 10,0.0, $x+5, $y+15, $this->color["black"] , $font, $text);
	}
	
	function set_colors(){
		$this->color["white"] = imagecolorallocate($this->img, 255,   255,  255);
		$this->color["black"] = imagecolorallocate($this->img, 0,   0,  0);
		$this->color["gray"]   = imagecolorallocate($this->img, 240,   240,  240);
	}
	
	function set_canvas(){
		// black border
		imagerectangle($this->img, 0,0,$this->maxwidth-1, $this->maxheight-1, $this->color["black"]);
		// white background
		imagefilledrectangle($this->img, 1,1,$this->maxwidth-2, $this->maxheight-2, $this->color["white"]);
	}
	
}