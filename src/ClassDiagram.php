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
        $this->dependencies_resolved = true;
    }
    private $dependencies_resolved = false;
    function is_dependencies_resolved(){
        return $this->dependencies_resolved ;
    }
}