<?php
namespace src;

class grid {

    private $classes = [];
    function add_element( class_ $class ){
        $name = $class->get_name();
        $this->classes[ $name ] = [ "class" => $class, "placed" => false, "x" => 0, "y" => 0 ];
        // $this->classes[ $name ] = [ "class" => $class, "placed" => false ];
    }
    function get_num_classes() : int {
        return count( $this->classes );
    }

    function is_placed( string $classname ){
        return $this->classes[$classname]["placed"];
    }

    private $matrix = [];
    function distribute(){
        $firstx = 0;
        $firsty = 1;
        foreach ($this->classes as $name => $class ){
            $class = force_class( $class["class"] );
            if( $class->get_extends() == [] ){
                $firstx ++;    
            } else {
                $firsty ++;
            }
            $x = $firstx;
            $y = $firsty;
            
            if( ! array_key_exists( $x, $this->matrix ) ){
                $this->matrix[$x] = [];
            }
            
            
            while( array_key_exists( $y, $this->matrix[$x] ) ){
                $y ++;    
            }
            
            $this->classes[ $name ]["x"] = $x;
            $this->classes[ $name ]["y"] = $y;
            $this->classes[ $name ]["placed"] = true;
            $this->matrix[$x][$y] = $name; 
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