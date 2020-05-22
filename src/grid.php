<?php
namespace src;

class grid {

    private $classes = [];
    function add_element( class_ $class ){
        $name = $class->get_name();
        $this->classes[ $name ] = [ "class" => $class, "placed" => false, "x" => 0, "y" => 0 ];
        // $this->classes[ $name ] = [ "class" => $class, "placed" => false ];
    }
    function get_classes() : Array {
        return $this->classes ;
    }
    
    function get_num_classes() : int {
        return count( $this->classes );
    }

    function is_placed( string $classname ){
        return $this->classes[$classname]["placed"];
    }

    function max_x() : int{

        return count( $this->matrix );
    }

    function max_y() : int{
        $max_y = 0;
        foreach( $this->matrix as $column ){
            $count = count($column);
            if( $max_y < $count ){
                $max_y = $count;
            }
        }
        return $max_y;
    }

    private $img;
    private $color = [];
    private $maxwidth;
    private $maxheight;
    
    function draw(){
        $testGD = get_extension_funcs("gd"); // Grab function list
        if (!$testGD){
            echo "GD not even installed.";
            return;
        }
        
        $this->maxwidth = $this->max_x() * 200;
        $this->maxheight = $this->max_y() * 200;
        
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

        
//         $this->draw_grid($this->img, 0,0,15,20,20,10,$this->color["gray"]);
        
        foreach ($this->classes as $name => $class ){
            if( ! $this->classes[ $name ]["placed"] ){
                continue;
            }
            $class["class"] = force_class( $class["class"] );

            $this->draw_class($name, $class);
        }
        
        foreach ($this->classes as $name => $class ){
            if( ! $this->classes[ $name ]["placed"] ){
                continue;
            }
            $class["class"] = force_class( $class["class"] );
            
            if( count( $class["children"] ) == 0 ){
                continue;
            }
            
            $this->draw_parent_child_arrows( $class );
        }
        
        
        /* canvas border
         * we do this as last step in case we need to grow the area
         */
        imagerectangle($this->img, 0,0,$this->maxwidth-1, $this->maxheight-1, $this->color["black"]);
        
        \imagepng($this->img,"/var/www/htdocs/salida.png");
        
        imagedestroy($this->img);
    }
    
    /* TODO: calculate heigh based on the number of functions
     */
    private function draw_class( string $name, Array $class ){
        $x = $this->calc_real_x( $class["x"] );
        $y = $this->calc_real_y( $class["y"] );
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
    private function calc_real_x( int $x ) : int {
        return ( ( $x -1 ) *150 )+50;
    }
    private function calc_real_y( int $y ) : int {
        return ( ( $y -1 ) *100 )+50;
    }
    
    private function draw_parent_child_arrows( Array $class ){
        $children = $class[ "children" ];
        
        $count = count( $children );
        /*
         * lets do this simple, 
         * just a line from upper left corner of each class to each child
         */
        for( $index = 0 ; $index < $count ; $index ++ ){
            // calculate top point
            $x1 = $this->calc_real_x( $class["x"] ) + (ceil(100/($count+1) )*($index+1)) ;
            $y1 = $this->calc_real_y( $class["y"] ) + 50;
            $childname = $class["children"][$index];
            $child = $this->classes[ $childname ];
            // (ceil(100/($count+1))*($index+1)
            $x2 = $this->calc_real_x( $child["x"] ) + 50 ;
            $y2 = $this->calc_real_y( $child["y"] );
            
            $this->white_arrow($x1, $y1, $x2, $y2);
            
            
            
//             imagepolygon($this->img, $points, 3, $this->color["black"]);
//             imageline ( $this->img , $x2 , $y2 , $xx1 , $yy1 , $this->color["black"] );
//             imageline ( $this->img , $x2 , $y2 , $xx2 , $yy2 , $this->color["black"] );
        }

    }
    
    private function white_arrow( int $x1, int $y1, int $x2, int $y2 ) {
        /* calculate angle of the line
         */
        $delta_x = $x2 - $x1;
        $delta_y = $y2 - $y1;
        $theta_radians = atan2( $delta_y, $delta_x);

        /* create two new angles for the arrow head
         */
        $alpha1 = $theta_radians + 0.261799;
        $alpha2 = $theta_radians - 0.261799;

        $distance = 3;
        $point1 = $this->calculate_point($x1, $y1, $x2, $y2, $distance, $alpha1 );
        $x1 = $point1["x"];
        $y1 = $point1["y"];
        
        /* calculate new points for the arrow head
         */
        $distance = 15;
        $point1 = $this->calculate_point($x1, $y1, $x2, $y2, $distance, $alpha1 );
        $xx1 = $point1["x"];
        $yy1 = $point1["y"];

        $point1 = $this->calculate_point($x1, $y1, $x2, $y2, $distance, $alpha2 );
        $xx2 = $point1["x"];
        $yy2 = $point1["y"];
        
        
        
        
        // draw the line
        imageline ( $this->img , $x1 , $y1+1 , $x2 , $y2 , $this->color["black"] );
        $points = array( $x1, $y1+1 , $xx1, $yy1 , $xx2, $yy2 );
        
        // draw the head, first filled, then border
        imagefilledpolygon($this->img, $points, 3, $this->color["white"]);
        imagepolygon($this->img, $points, 3, $this->color["black"]);
    }
    
    private function calculate_point( int $x1, int $y1, int $x2, int $y2, int $distance, float $radians ) : Array {
        $point = [];
        $point["x"] = $x1 + ( $distance * cos($radians) );
        $point["y"] = $y1 + ( $distance * sin($radians) );
        return $point; 
    }
    
    
    function to_degrees( float $radians ) : float {
        return $radians * 180 / pi();
    }
    function to_radians( float $degrees ) : float {
        return $degrees / 180 * pi();
    }
    
    
    /* this was copy/pasted from php.net
     */
    function draw_grid(&$img, $x0, $y0, $width, $height, $cols, $rows, $color) {
        //draw outer border
        imagerectangle($img, $x0, $y0, $x0+$width*$cols, $y0+$height*$rows, $color);
        //first draw horizontal
        $x1 = $x0;
        $x2 = $x0 + $cols*$width;
        for ($n=0; $n<ceil($rows/2); $n++) {
            $y1 = $y0 + 2*$n*$height;
            $y2 = $y0 + (2*$n+1)*$height;
            imagerectangle($img, $x1,$y1,$x2,$y2, $color);
        }
        //then draw vertical
        $y1 = $y0;
        $y2 = $y0 + $rows*$height;
        for ($n=0; $n<ceil($cols/2); $n++) {
            $x1 = $x0 + 2*$n*$width;
            $x2 = $x0 + (2*$n+1)*$width;
            imagerectangle($img, $x1,$y1,$x2,$y2, $color);
        }
    }
    
    private $matrix = [];
    
    function distribute( string $parent = "" ){
        if( $parent == "" ){
            $firstx = 1;
            $firsty = 1;
        } 
        
        foreach ($this->classes as $name => $class ){
            if( $this->classes[ $name ]["placed"] ){
                continue;
            }
            
            $class = force_class( $class["class"] );
            $extends = $class->get_extends();
            
            /* 
             */
            if( $extends != [] ){
                if( $parent == ""){
                    continue;
                }

                // TODO: see if array_search meets the ends
                $found = false;
                foreach( $extends as $extend ){
                    if( $parent == $extend ){
                        $found = true;
                        break;
                    }
                }
                if( !$found ){
                    continue;
                }
                $this->classes[$parent]["children"][] = $name;
                $firstx = $this->classes[$parent]["x"];
                $firsty = $this->classes[$parent]["y"]+1;
                while( isset( $this->matrix[$firstx][$firsty] ) ){
                    $firstx++;
                }
                
            } else {
                if( $parent != ""){
                    continue;
                }
                
                /* if the "column" exist, means some other class is using it
                 */
                while( isset( $this->matrix[$firstx] ) ){
                    $firstx++;
                }

                $num_children = $this->get_num_children($name);
                if( $num_children > 2 ){
                    $offset = floor( $num_children / 2 );
                    $firstx += ( $offset  ); //
                    if( floor( $this->get_num_children($name) % 2 ) == 0 ){
                        $firstx --;
                    }
                }
                
            }
            
            $x = $firstx;
            $y = $firsty;
            
            
            $this->classes[ $name ]["x"] = $x;
            $this->classes[ $name ]["y"] = $y;
            $this->classes[ $name ]["placed"] = true;
            $this->classes[ $name ]["children"] = [];
            $this->matrix[$x][$y] = $name;
            
            $this->distribute($name);
        }
    }
    
    private function get_num_children( string $name ) : int {
        $count = 0;
        foreach( $this->classes as $class ){
            $class = force_class($class["class"]);
            foreach( $class->get_extends() as $parentname ){
                if( $parentname === $name ){
                    $count ++;
                }
            }
        }
        return $count;
    }
    
    function get_pos_x( string $classname ): int {
        return $this->classes[ $classname ]["x"];
    }
    function get_pos_y( string $classname ): int {
        return $this->classes[ $classname ]["y"];
    }
    
    
//     function get_num_rows() : int{
//         $num_rows = 0;
//         foreach( $this->columns as $column ){
//             $rows = $this->calculate_rows( $column );
//             if( $rows > $num_rows ){
//                 $num_rows = $rows;
//             }
//         }
//         return $num_rows;
//     }
    
//     function get_num_columns() : int{
//         return count( $this->columns );
//     }
    
}