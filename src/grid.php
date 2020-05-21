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
            $x1 = $this->calc_real_x( $class["x"] ) + (ceil(100/($count+1))) ;
            $y1 = $this->calc_real_y( $class["y"] ) + 50;
            $childname = $class["children"][$index];
            $child = $this->classes[ $childname ];
            $x2 = $this->calc_real_x( $child["x"] ) + (ceil(100/($count+1))) ;
            $y2 = $this->calc_real_y( $child["y"] );
            
            $delta_x = $x2 - $x1;
            $delta_y = $y1 - $y1;
            $theta_radians = atan2( $delta_y, $delta_x);

            $alpha1 = $this->to_degrees($theta_radians)+5;
            $alpha2 = $this->to_degrees($theta_radians)-5;
            
            $xx1 = $x2 + $this->to_radias( (10 * cos($alpha1)));
            $yy1 = $y2 + $this->to_radias( (10 * sin($alpha1)));
            $xx2 = $x2 + $this->to_radias( (10 * cos($alpha2)));
            $yy2 = $y2 - $this->to_radias( (10 * sin($alpha2)));
            
            imageline ( $this->img , $x1 , $y1 , $x2 , $y2 , $this->color["black"] );
            
            imageline ( $this->img , $x2 , $y2 , $xx1 , $yy1 , $this->color["black"] );
            imageline ( $this->img , $x2 , $y2 , $xx2 , $yy2 , $this->color["black"] );
        }

    }
    function to_degrees( float $radians ) : float {
        return $radians * 180 / pi();
    }
    function to_radias( float $degrees ) : float {
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