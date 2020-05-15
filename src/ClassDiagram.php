<?php
namespace src;

class ClassDiagram {
    private $classes = [];
    
    function addClasses( Array $classes ){
        foreach ($classes as $class ){
            $this->classes[] = $class;
        }
    }
    function addClass( class_ $class ){
        $this->classes[] = $class;
    }
    function get_classes() : Array {
        return $this->classes;
    }
    
//     function find_parent( string $parent ) : clase {
//         foreach ($this->classes as $value ){
//             $class = $this->convert2class( $value );
//             if( $class->get_name() == $parent ){
//                 return $class;
//             }
//         }
//         return new clase_null("");
//     }
    
//     function resolve_dependencies(){
//         $this->dependencies_resolved = false;
//         foreach ($this->classes as $value ){
//             $class = $this->convert2class( $value );
//             $extends = $class->get_extends();
//             $parent = $this->find_parent( $extends );
            
//         }
//     }
    
    private $dependencies_resolved = false;
    function is_dependencies_resolved(){
        return $this->dependencies_resolved ;
    }
}