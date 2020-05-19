<?php
namespace src;

class grid {
    
    private $matrix = [];

    function add_element( class_ $class ){
        // by doing this we are adding a new "column"
        $name = $class->get_name();
        $extends = $class->get_extends();
        if( $extends == ""){
            $this->matrix[ $name ] = [ $class ];
        } else {
            $this->matrix[ $extends ][ $name ] = [ $class ];
        }
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