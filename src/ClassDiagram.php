<?php
namespace src;

class ClassDiagram {
    private $classes = [];
    
    function addClasses( Array $classes ){
        foreach ($classes as $class ){
            $this->classes[] = $class;
        }
    }
    function resolve_dependencies(){
        
    }
    function dependencias_resueltas(){
        return true;
    }
}