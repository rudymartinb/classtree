<?php
namespace src;

class grid {
    
    private $matrix = [];

    private $classes = [];
    function add_element( class_ $class ){
        // by doing this we are adding a new "column"
        $name = $class->get_name();
        $this->classes[ $name ] = $class;
        $extends = $class->get_extends();
        if( $extends == []){
            $this->matrix[ $name ] = [ $name ];
        } else {
            foreach( $extends as $extend ){
                $this->matrix[ $extend ][ $name ] = [ $name ];
            }
            
        }
    }
    
    function get_num_elements() : int {
        return count( $this->classes );
    }
    
    function get_rows() : int{
        $num_rows = 0;
        foreach( $this->matrix as $column ){
            if( $num_rows < count( $column ) ){
                $num_rows =  count( $column ) ;
            }
        }
        return $num_rows;
    }
    function get_columns() : int{
        return count( $this->matrix );
    }
    
}