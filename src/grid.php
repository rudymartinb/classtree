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

    function draw(){
        
        //example
        $img = imagecreatetruecolor(300, 200);
        $white = imagecolorallocate($img, 255,   255,  255);
        imagefilledrectangle($img, 0,0,299,299, $white);
        
        $gray   = imagecolorallocate($img, 224,   224,  224);
        $this->draw_grid($img, 0,0,15,20,20,10,$gray);
//         header("Content-type: image/png");
        
        
        imagejpge($img,"/tmp/salida.jpg");
        imagedestroy($img);
        
    }
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