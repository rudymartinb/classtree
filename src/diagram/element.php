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
	function draw( $img ) {
		$testGD = get_extension_funcs("gd"); // Grab function list
		if (!$testGD){
			echo "GD not even installed.";
			return;
		}
		
		$layout = new vertical_layout();
		$layout->set_xy($this->x, $this->y);
		if( $this->type != "class" ){
			$layout->add( $this->type_draw );
		}
		$layout->add(new draw_text($this->name));
		if( $this->extends != "" ){
			$layout->add( $this->extends_draw );
		}
		foreach( $this->implements_draw as $implements ){
			$layout->add( $implements );
		}
		foreach ($this->functions_draw as $function ){
			$layout->add( $function );
		}
// 		
		
		
		$this->maxwidth = 1024;
		$this->maxheight = 768;
		
		$this->img = imagecreatetruecolor( $this->maxwidth, $this->maxheight);
		
		// TODO: move to Diagram()
		$this->set_colors();
		$this->set_canvas();
		
		imageantialias ( $this->img, true );

		$x = $this->x;
		$y = $this->y;
		$width = $layout->get_max_width();
		$height = $layout->get_max_height();
		
		imagefilledrectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["white"] );
		imagerectangle($this->img, $x, $y, $x+$width, $y+$height, $this->color["black"] );
		
		$layout->draw( $this->img );
		imagepng($this->img,"/var/www/htdocs/salida.png");
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