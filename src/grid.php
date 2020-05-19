<?php
namespace src;

class grid {
    
    private $matrix = [];

    private $classes = [];
    function add_element( class_ $class ){
        $name = $class->get_name();
        $this->classes[ $name ] = $class;
    }
    
    // each "column" will have only 1 parent and its direct childs 
    // as long as none of those childs
    private $columns = [];
    function get_columns() : Array {
        return $this->columns;
    }

    function distribute(){
        foreach ($this->classes as $class ){
            $class = force_class($class);
            $name = $class->get_name();
            $extends = $class->get_extends();
            if( $extends == [] ){
                $this->columns[ $name ] = [ "name" => $name, "children" => [] ]; 
            } else {
                foreach( $extends as $parent ){
                    $this->columns[ $parent ]["children"] = $name; 
                }
            }
        }
        
    }
    
    function get_num_elements() : int {
        return count( $this->classes );
    }
    
    function get_num_rows() : int{
        $num_rows = 1;
        return $num_rows;
    }
    function get_num_columns() : int{
        return count( $this->columns );
    }
    
}