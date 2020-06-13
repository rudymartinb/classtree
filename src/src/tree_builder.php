<?php
namespace src;

use scr\node;
use function scr\force_tree;
use diagram\vertical_layout;

abstract class tree_builder {
	use node_positions;
	
	private $tree = [];
	protected $collector;
	
	abstract function get_new_collector() : collector ;
	
	function get_max_columns(): int{
		return $this->max_columns( $this->tree );
	}
	function get_max_height(): int{
		return $this->max_height( $this->tree );
	}

	function get_relative_column( string $classname, Array $trees = null ) : int {
		return $this->get_relative_column2($classname, $this->tree );
	}

	function get_relative_row( string $classname, Array $trees = null ) : int {
		return $this->get_relative_row2($classname, $this->tree );
	}

	function get_relative_inner_column( string $classname, Array $trees = null ) : float {
		return $this->get_relative_inner_column2($classname, $this->tree );
	}
	

	
	function resolve_hierarchy() {
		$this->tree = $this->resolve();
		$this->calculate_relative_positions( $this->tree );
	}
	
	private function resolve( string $parent = "" ) {
		$tree = [];
		
		// by doing this we keep the internal pointer
		// separated on each recursive call.
		$collector = $this->get_new_collector();
		
		while( $collector->more_elements() ){
			
			$node_name = $collector->get_name();
			$extends = $collector->get_extends();
			
			if( $parent !== "" ){
				if( $extends != $parent ) {
					$collector->next();
					continue;
				}
			} else {
				if( $extends !== "" ){
					$collector->next();
					continue;
				}
			}
			$children = $this->resolve( $node_name );
			
			
			$node = new node( $node_name );
			$node->set_extends($extends);
			$node->set_children($children);
			$node->set_width( max( $this->max_columns( $children ), 1 ) );
			$node->set_height( $this->max_height( $children )+1 );
			$node->do_layout();
			$tree[] = $node;
			$collector->next();
		}
		return $tree;
	}
	
	function add_source(string $source) {
		$nsfinder = new namespace_finder($source);
		while($nsfinder->more()){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->collector->add_source( $body, $namespace );
			$nsfinder->next();
		}
	}
	
	private $max_node_width_px = 0;
	private $max_node_height_px = 0;
	function get_max_width_px(){
		return $this->get_max_width_px_2( $this->tree );
	}
	function get_max_width_px_2( Array $trees ){
		$max_width = 0;
		foreach( $trees as $node ){
			$node = force_tree( $node );
			$layout = $node->get_layout();
			$width = $layout->get_max_width();
			if( $max_width < $width ){
				$max_width = $width;
			}
			$width = $this->get_max_width_px_2( $node->get_children() );
			if( $max_width < $width ){
				$max_width = $width;
			}
		}
		return $max_width;
	}
	function get_max_height_px() : int {
		return $this->get_max_height_px_2( $this->tree );
	}
		
	private	function get_max_height_px_2( Array $trees ) : int {
		$max_height = 0;
		foreach( $trees as $node ){
			$node = force_tree( $node );
			$layout = $node->get_layout();
			$height = $layout->get_max_height();
			if( $max_height < $height ){
				$max_height = $height;
			}
			$height = $this->get_max_height_px_2( $node->get_children() );
			if( $max_height < $height ){
				$max_height = $height;
			}
		}
		return $max_height;
	}
	
	
	private $width_margin = 2;
	private $height_margin = 2.5;
	private $max_img_width;
	private $max_img_height;
	function draw() {
		$this->calculate_relative_positions();
		
		$this->max_node_width_px = $this->get_max_width_px();
		$this->max_node_height_px = $this->get_max_height_px();
// 		var_dump( "MX" , $this->max_node_width_px, $this->max_node_height_px );
// 		var_dump( "CX" , $this->get_max_width(), $this->get_max_height()  );
		
		$this->max_img_width = ($this->get_max_columns()+0)  * $this->max_node_width_px * $this->width_margin + ($this->max_node_width_px*$this->width_margin/2  ) ;
		$this->max_img_height = ($this->get_max_height()+0) * $this->max_node_height_px * $this->height_margin  + ($this->max_node_height_px * $this->height_margin /2) ;
// 		var_dump( "IX" , $this->max_img_width, $this->max_img_height  );
		
		$img = imagecreatetruecolor( $this->max_img_width  , $this->max_img_height );
// 		$img = imagecreatetruecolor( 1000 , 800 );
		/* background color
		 */
		$this->color["white"] = imagecolorallocate($img, 255,   255,  255);
		$this->color["black"] = imagecolorallocate($img, 0,   0,  0);
		$this->color["gray" ] = imagecolorallocate($img, 240,   240,  240);
		
		/* canvas
		 */
		
		imagefilledrectangle( $img, 0,0,$this->max_img_width-1, $this->max_img_height-1, $this->color["white"]);
// 		imagefilledrectangle( $img, 0,0,1000, 800, $this->color["white"]);
		imageantialias ( $img, true );
		
		$this->img = $img;
		$this->draw_tree( $this->tree );
		
		\imagepng($this->img,"/var/www/htdocs/salida.png");

	}
	
	private function draw_tree( Array $trees ) {
		foreach( $trees as $node ){
			$this->draw_node( $node );
			$this->draw_tree( $node->get_children() );
		}
	}
	
	private function draw_node( node $node ){
		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->add_text( $node->get_name() );
		$layout->do_layout();
		$x = ( ( $node->get_relcol()+($node->get_width()/2) ) * $this->max_node_width_px  * $this->width_margin  ) + ($this->max_node_width_px / 2 );
		$y = ( ( $node->get_relrow()  ) * $this->max_node_height_px * $this->height_margin ) + ($this->max_node_height_px / 2 );
		
		$layout->set_xy( $x, $y );
		
		$layout->do_layout();
		$layout->draw( $this->img );
	}
	
	
	
	
}