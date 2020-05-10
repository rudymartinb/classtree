<?php

use nodes\node_clase;

class ClassTree {
    
    private $nodos = [] ;
    
    function get_nodos() : Array {
        return $this->nodos;
    }
    private $clases = [];
    function get_clases() : Array {
        return $this->clases;
    }
    private function separar_clases( Array $matches ) : Array {
        $lista = [];
        $namespace = "";
        foreach ($matches["tipo"] as $key => $value ) {
            if( $value == "namespace" ){
                $namespace = $matches[ "nombretipo" ][ $key ];
                continue;
            }
            if( $value != "class" ){
                continue;
            }
            
            $clase = new clase( $matches[ "nombretipo"][$key] );
            $clase->set_extends( $matches["extends"][$key] );
            $clase->set_implements( $matches["implements"][$key] );
            $clase->set_namespace( $namespace );
            
            $lista[] = $clase;
        }
        return $lista;
    }
    private function separar_nodos( Array $matches ) : Array {
        $lista = [];
        $namespace = "";
        foreach ($matches["tipo"] as $key => $value ) {
            if( $value == "namespace" ){
                $namespace = $matches[ "nombretipo" ][ $key ];
                continue;
            }
            if( $value != "class" ){
                continue;
            }
            
            $clase = new node_clase( $matches[ "nombretipo"][$key] );
            $clase->set_extends( $matches["extends"][$key] );
            $clase->set_implements( $matches["implements"][$key] );
            $clase->set_namespace( $namespace );
            
            $lista[] = $clase;
        }
        return $lista;
    }
    
    
    private function es_entrada_con_punto( string $entry ) : bool {
        return substr( $entry, 0,1 ) == ".";
    }
    private function es_php( string $entry ) : bool {
        return substr( $entry, -4 ) != ".php";
    }
    
    function construir( string $path, array $lista = [] ) : array {
        $dir = dir($path);
        while (false !== ($entry = $dir->read())) {
            if( $this->es_entrada_con_punto($entry) ){
                continue;
            }
            
            $newpath = $path."/".$entry;
            
            if( is_dir( $newpath ) ){
                $nueva = $this->construir( $newpath );
                $lista = $lista + $nueva;
            }
            if( $this->es_php($entry) ){
                continue;
            }
            
            $lista[ $newpath ] = "" ; // $entry;
            
            $matches = $this->get_tipos_del_fuente( $newpath );
            $clases = $this->separar_clases( $matches );
            $this->clases = $this->clases + $clases;
            
        }
        return $lista;
    }
    function construir_desde_archivo( string $entry ) : array {
        $lista = [];
        if( $this->es_entrada_con_punto( $entry ) ){
            return $lista;
        }
        
        if( $this->es_php($entry) ){
            return $lista;
        }
        
        $lista[ $entry ] = ""; 
        
        $matches = $this->get_tipos_del_fuente( $entry );
        $clases = $this->separar_clases( $matches );
        $this->clases = $this->clases + $clases;
            
        return $lista;
    }
    
    
    private $identificadores;
    
    private function get_tipos_del_fuente( string $filename ): Array {
        $lista = file_get_contents( $filename );
        
        // (implements (?<implements>[0-9a-zA-Z_]*))*[ {]*
        $pattern  = "/(?<tipo>class|interface|namespace)[ ]*";
        $pattern .= "(?<nombretipo>[0-9a-zA-Z_]*)[ ]*";
        $pattern .= "(extends (?<extends>[0-9a-zA-Z_]*)|)[ ]*";
        $pattern .= "(implements (?<implements>[0-9a-zA-Z_]*)|)*[ {]*/";
        
        $matches = [];
        preg_match_all($pattern, $lista, $matches );
        // var_dump( $matches );
        
        return $matches;
    }

    /* no se si la voy a terminar usando
     * por cuanto esto implicaria revisar el codigo interno de cada funcion linea por linea
     * para ver las dependencias que tiene.
     * 
     * y aparte tengo otro problema:
     * no puedo saber el resultado de llamadas a metodos de objetos
     * sin consultar el objeto en cuestion
     * 
     * por lo tanto es como que cada instancia del objeto clase 
     * deberia tener un atributo que diga si se termino de consultar todo o no
     * 
     */
    function get_funciones( string $filename, string $class ): Array {
        $sourcecode = file_get_contents( $filename );

        /* extract classes from source
         */
        $classpart = "class ".$class."";
        
        $pattern  = "/";
        $pattern .= "(?:(?!".$classpart.").)";
        $pattern .= "(?:".$classpart.")";
        $pattern .= ".+?";
        $pattern .= "(?:(?=class))";
        $pattern .= "/s";
                
        $matches = [];
        preg_match_all( $pattern, $sourcecode, $matches );
        
        $classbody = $matches[0][0];
        if( is_null( $classbody ) ){
            return [];
        }

        /* extract functions from class body
         */
        $pattern  = "/";
        $pattern .= "(?:function) ";
        $pattern .= "(?<nombretipo>[0-9a-zA-Z_]*)[ ]*";
        $pattern .= "[(]{1}";
        $pattern .= "(?<params>[ $0-9a-zA-Z_,]*)";
        $pattern .= "[)]{1}";
        $pattern .= "(?<ret>[ :$0-9a-zA-Z_,]*)";
        $pattern .= "/s";
        
        $func_matches = [];
        preg_match_all( $pattern, $classbody, $func_matches  );
                
        return $func_matches;
    }
    
    
}