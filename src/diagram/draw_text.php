<?php
namespace diagram;


class draw_text implements component {
	protected $text ;
	protected $height_px;
	protected $width_px;
	
	// WARNING: PHP properties varialbes are initilized AFTER the __construct() call !!
	private $font_size; 
	private $width = 0;
	function set_width( int $width ){
		$this->width = $width;
	}
	
	private $draw_function;
	function set_draw_function( Callable $function ){
		$this->draw_function = $function;
	}
	
	// TODO: replace $img with an object
	function draw( $img ){
		
		if( $img === null ){
			return;
		}
		
		$font = self::$project_path.'/fonts/courier.ttf';
		
		$font = trim( realpath($font) );
// 		$font = './fonts/courier.ttf';
		
		$font = realpath($font) ;
		if( !file_exists($font) ){
			echo "'".$font."'\n";
		}
		
		$function = $this->draw_function;
		
		$function( $img, $font );

	}
	
	// HACK: set the project path
	static private $project_path = "./";
	static function set_path( string $path ){
		self::$project_path = $path.'/';
	}
	
	function __construct( string $text  ){
		$this->font_size = 10;
		
		$size = $this->font_size;
		$this->draw_function = function( $img, $font ) use( $size ){
			\imagettftext($img, $size,0.0, $this->x, $this->y, $this->color["black"] , $font, $this->text);
		};
		
		$this->text = $text;
		$font = self::$project_path.'/fonts/courier.ttf';
		
		$font = trim( realpath($font) );
		$arr = imagettfbbox( $this->font_size, 0.0, $font, $text);
		$this->height_px = $arr[1] - $arr[5];
		$this->width_px = $arr[4] - $arr[0];
	}
	
	function get_height( ) : int {
		return $this->height_px;
	}
	
	function get_width( ) : int {
		return $this->width_px;
	}
	private $x = 0;
	private $y = 0;
	function set_xy(int $x, int $y) {
		$this->x = $x;
		$this->y = $y;
	}
	
	function get_x(): int {
		return $this->x;
	}
	
	function get_y(): int {
		return $this->y;
	}
	

	
}