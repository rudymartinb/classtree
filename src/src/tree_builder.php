<?php
namespace src;

use scr\node;
use function scr\force_tree;
use diagram\vertical_layout;

abstract class tree_builder {
	use node_positions;
	
	private $tree = [];
	private $iftree = [];
	
	// for DEBUG
	function get_iftree() : Array {
		return $this->iftree;
	}
	protected $collector;
	protected $ifcollector;
	
	abstract function get_new_collector() : collector ;
	
	function get_max_columns(): int{
		return max( $this->max_columns( $this->tree ), $this->max_columns( $this->iftree ) );
	}
	function get_max_height(): int{
		return $this->max_height( $this->iftree ) + $this->max_height( $this->tree );
	}

	function get_relative_column( string $classname, Array $trees = null ) : int {
		return $this->get_relative_column2($classname, $this->tree );
	}

	function get_relative_row( string $classname, Array $trees = null ) : int {
		return $this->get_relative_row2($classname, $this->tree );
	}
	
	function add_source( string $source ) {
		$nsfinder = new namespace_finder($source);
		while( $nsfinder->more() ){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->ifcollector->add_source( $body, $namespace );
			$this->collector->add_source( $body, $namespace );
			$nsfinder->next();
		}
	}
	
	
	function resolve_hierarchy() {
		$this->iftree = $this->resolve_by_collector( "", $this->ifcollector );
		$this->tree = $this->resolve_by_collector( "", $this->collector );
		$this->calculate_relative_positions( $this->iftree );
		$this->calculate_relative_positions( $this->tree, $this->iftree );
	}
	
	private function resolve_by_collector( string $parent, collector $collector ) : Array {
		// by doing this we keep the internal pointer
		// separated on each recursive call.
		$collector = $collector->clone();
		$tree = [];
		while( $collector->more_elements() ){
			
			$node_name = $collector->get_name();
			$extends = $collector->get_extends();
			
			/* if implements is not empty
			 * I want to search on the iftree to get the nodes by name
			 * if they are not present, we will ignore it for now.
			 */
			$implements = $this->get_nodes_from_interfaces( $collector->get_implements() );

			
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
			$children = $this->resolve_by_collector( $node_name, $collector );
			
			
			$node = new node( $node_name );
			$node->set_extends($extends);
			$node->set_children($children);
			$node->set_implements($implements);
			$node->set_width( max( $this->max_columns( $children ), 1 ) );
			$node->set_height( $this->max_height( $children )+1 );
			$node->do_layout();
			$tree[] = $node;
			
			$collector->next();
		}
		return $tree;
	}
	
	function get_nodes_from_interfaces( Array $interfaces ) : Array {
		$nodes = [];
		foreach ($interfaces as $interfaces ){
			$ifname = $interfaces["ifname"];
			$nodes[] = $this->search_tree( $ifname, $this->iftree,
					function( node $tree ){
						return $tree;
					} );
		}
		return $nodes;
		
	}
	
	private function search_tree( $classname, Array $trees, Callable $return ) {
		foreach( $trees as $tree ){
			if( $tree->get_name() == $classname ){
				return $return( $tree );
			}
			$ret = $this->search_tree( $classname, $tree->get_children(), $return );
			if( $ret != -1 ){
				return $ret;
			}
		}
		// classname not found
		return -1;
	}
	
	
	/*
	 * 
	 * --------------------------------
	 * drawing functions
	 */
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
	
	
	private $width_margin = 1.3;
	private $height_margin = 3;
	private $max_img_width;
	private $max_img_height;
	private $color = [];
	function draw( string $output_file = "" ) {
// 		$this->calculate_relative_positions();
		
		$this->max_node_width_px = $this->get_max_width_px();
		$this->max_node_height_px = $this->get_max_height_px();

		$area_x = $this->max_node_width_px  * $this->width_margin ;
		$area_y = $this->max_node_height_px * $this->height_margin ;
		
		
		$this->max_img_width =  $this->get_max_columns() * $area_x ;
		$this->max_img_height = $this->get_max_height()  * $area_y ;
		
		$img = imagecreatetruecolor( $this->max_img_width  , $this->max_img_height );

		/* background color
		 */
		$this->color["white"] = imagecolorallocate($img, 255,   255,  255);
		$this->color["black"] = imagecolorallocate($img, 0,   0,  0);
		$this->color["gray" ] = imagecolorallocate($img, 240,   240,  240);
		$this->color["red" ] = imagecolorallocate($img, 192,   0,  0);
		

		
		
		/* canvas
		 */
		
		imagefilledrectangle( $img, 0,0,$this->max_img_width-1, $this->max_img_height-1, $this->color["white"]);

// 		imageantialias ( $img, true );
		$this->grid( $img, $area_x , $area_y );
		
		$this->img = $img;
		$this->draw_tree( $this->iftree );
		$this->draw_tree( $this->tree );
		if( $output_file == "" ){
			$output_file = "examples/output.png";
		}
		\imagepng($this->img,$output_file);

	}
	private function grid( $img, $area_x, $area_y ){
		// draw background grid
		for( $ix = 0; $ix < $this->get_max_columns() ; $ix ++ ){
			for( $iy = 0; $iy < $this->get_max_height() ; $iy ++ ){
				$ix_px = $ix * $area_x;
				$iy_px = $iy * $area_y;
				imagerectangle( $img, $ix_px, $iy_px, $ix_px+ $area_x-1, $iy_px+$area_y-1, $this->color["gray"]);
				
			}
		}
		
	}
	
	private function draw_tree( Array $trees, node $parent = null ) {
		foreach( $trees as $node ){
			$this->draw_node( $node, $parent );
			$this->draw_arrows_implements( $node );
			$this->draw_tree( $node->get_children() );
			$this->draw_arrows( $node );
		}
	}
	
	private function draw_node( node $node ){
		$layout = $this->get_node_layout($node);
		/* width refers to the total tree width site at this node
		 * which means can be 1 at minimum (self)
		 */
		$width = $layout->get_max_width();
		$height= $layout->get_max_height();

		$posx = $this->get_x_from_node( $node, $width );
		
		$posy = $this->get_y_from_node( $node, $height );
		
		$layout->set_xy( $posx, $posy );
		
		$layout->do_layout();
		$layout->draw( $this->img );
	}
	
	function draw_arrows( node $parent ){
		$parent = force_tree($parent);
		$layout_parent = $this->get_node_layout( $parent );
		
		
		$num_children = count( $parent->get_children() );

		$width = $layout_parent->get_max_width();
		$height= $layout_parent->get_max_height();
		
		$posx = $this->get_x_from_node( $parent, $width ) ;
		$posy = $this->get_y_from_node( $parent, $height ) + $height;
		
		foreach ( $parent->get_children() as $index => $child_node ){
			$finalx = $posx + ($width/(($num_children+1))*($index+1));
			$layout_child = $this->get_node_layout( $child_node );
			$child_width = $layout_child->get_max_width();
			$cposx = $this->get_x_from_node($child_node, $child_width)+($child_width/2);
			$cposy = $this->get_y_from_node( $child_node, $height );
			$this->white_arrow($finalx, $posy, $cposx, $cposy);
		}
	}

	
	/*
	 * in this case, 
	 * parent will always be below interfaces
	 * and arrow type must be different
	 */
	function draw_arrows_implements( node $parent ){
		$parent = force_tree($parent);
		$layout_parent = $this->get_node_layout( $parent );
		
		
		$num_children = count( $parent->get_implements() );
		
		$width = $layout_parent->get_max_width();
		$height= $layout_parent->get_max_height();
		
		$posx = $this->get_x_from_node( $parent, $width ) ;
		$posy = $this->get_y_from_node( $parent, $height ) ;
		
		/*
		 * ok, at this point I need to look for
		 */
		foreach ( $parent->get_implements() as $index => $child_node ){
			if( $child_node === -1 ){
				continue;
			}
			$finalx = $posx + ($width/(($num_children+1))*($index+1));
			$layout_child = $child_node->get_layout();
			$child_width = $layout_child->get_max_width();
			$cposx = $this->get_x_from_node($child_node, $child_width)+($child_width/2);
			$cposy = $this->get_y_from_implements( $child_node, $height );
			$this->white_arrow($cposx, $cposy, $finalx, $posy, 2 );
		}
	}
	function get_y_from_implements( node $node, int $height ) : int {
		$y0 = ( ( $node->get_relrow()  ) * $this->max_node_height_px * $this->height_margin ) ;
		$area_height = $this->max_node_height_px * $this->height_margin  ;
		$posy = ($area_height - $height) /2 + $height + $y0 ;
		return $posy;
	}
	
	/* x0 = starting X column
	 * area_width = based on node's width, used by the entire tree from this node
	 * posx = resulting centered position of the current node
	 */
	function get_x_from_node( node $node, int $width ) : int {
		$x0 = ( ( $node->get_relcol() ) * $this->max_node_width_px   * $this->width_margin  )  ;
		$area_width =  ( $node->get_width() * $this->max_node_width_px * $this->width_margin  )  ;
		$posx = ($area_width - $width) /2 + $x0;
		return $posx;
	}
	function get_y_from_node( node $node, int $height ) : int {
		$y0 = ( ( $node->get_relrow()  ) * $this->max_node_height_px * $this->height_margin ) ;
		$area_height = $this->max_node_height_px * $this->height_margin  ;
		$posy = ($area_height - $height) /2 + $y0;
		return $posy;
	}
	
	// TODO: place layout inside node?
	function get_node_layout( node $node ) : vertical_layout {
		$layout = new vertical_layout();
		$layout->set_margin(5);
		$layout->add_text( $node->get_name() );
		$layout->do_layout();
		return $layout;
	}
	
	
	private function white_arrow( int $x1, int $y1, int $x2, int $y2, int $arrow_type = 1 ) {
		/* calculate angle of the line
		 */
		$delta_x = $x2 - $x1;
		$delta_y = $y2 - $y1;
		$theta_radians = (float) atan2( $delta_y, $delta_x);
		
		/* create two new angles for the arrow head
		 */
		$rad = 90 * pi()/180;
		$alpha1 = $theta_radians + $rad ;
		$alpha2 = $theta_radians - $rad ;

		$distance = 2;
		$point1 = $this->calculate_point($x1, $y1, $x2, $y2, $distance, $theta_radians );
		$x1 = $point1["x"];
		$y1 = $point1["y"];
		
		// arrow head's "size"
		$distance = 10;  
		$point1 = $this->calculate_point($x1, $y1, $x2, $y2, $distance, $theta_radians );
		$x10 = $point1["x"];
		$y10 = $point1["y"];
		
		/* calculate new points for the arrow head
		 */
		$distance = 5;
		$point1 = $this->calculate_point($x10, $y10, $x2, $y2, $distance, $alpha1 );
		$xx1 = $point1["x"];
		$yy1 = $point1["y"];
		
		$point1 = $this->calculate_point($x10, $y10, $x2, $y2, $distance, $alpha2 );
		$xx2 = $point1["x"];
		$yy2 = $point1["y"];
		
		// draw the line
		imageline ( $this->img , $x1 , $y1 , $x2 , $y2 , $this->color["black"] );
		
		// draw the head, first filled, then border
		if( $arrow_type == 1 ){
			$points = array( $x1, $y1 , $xx1, $yy1 , $xx2, $yy2 );
			imagefilledpolygon($this->img, $points, 3, $this->color["white"]);
			imagepolygon($this->img, $points, 3, $this->color["black"]);
		} else {
			imageline($this->img, $x1, $y1 , $xx1, $yy1, $this->color["black"]);
			imageline($this->img, $x1, $y1 , $xx2, $yy2, $this->color["black"]);
		}
		
	}
	
	private function calculate_point( int $x1, int $y1, int $x2, int $y2, int $distance, float $radians ) : Array {
		$point = [];
		$point["x"] = $x1 + ( $distance * cos($radians) );
		$point["y"] = $y1 + ( $distance * sin($radians) );
		return $point;
	}
	
}