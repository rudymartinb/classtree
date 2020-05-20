<?php
namespace src;

class grid {
    
    private $matrix = [];

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

    function distribute(){
        $firstx = 1;
        $firsty = 1;
        foreach ($this->classes as $key => $class ){
            $class = force_class($class["class"]);
            $name = $class->get_name();
            $this->classes[ $name ]["x"] = $firstx;
            $this->classes[ $name ]["y"] = $firsty;
            $this->classes[ $name ]["placed"] = true;
            
        }
    }
    function get_posx( string $classname ): int {
        return $this->classes[ $classname ]["x"];
    }
    function get_posy( string $classname ): int {
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