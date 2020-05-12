<?php
namespace src;

class ClassDiagram {
    private $classes = [];
    
    function addClasses( Array $classes ){
        foreach ($classes as $class ){
            $this->classes[] = $class;
        }
    }
    function resolver_dependencias(){
        
    }
    function dependencias_resueltas(){
        return true;
    }
}