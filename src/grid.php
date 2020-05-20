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
            
            /* if theres any parent class
             * we need to know if theres one we are looking for
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