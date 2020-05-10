<?php



class classtreeTest extends PHPUnit\Framework\TestCase {
    
    /* this test uses a fixed file on tests/dummy dir
     * altering the file will cause this test to fail
     * 
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */
    function test_get_classes() {
        $path = "/home/rudy/projects/classtree/tests/dummy/";

        $classtree = new ClassTree();

        $classtree->construir( $path );
        
        $clases = $classtree->get_clases();
        // nombre primera clase
        $this->assertEquals( "father", $clases[0]->get_name() );

        $funciones = $classtree->get_funciones("/home/rudy/projects/classtree/tests/dummy/prueba.php", "father");
        $actual = $funciones["nombretipo"][0];
        
        $this->assertEquals("algo1", $actual);
        
        // nombre segunda clase
        $this->assertEquals( "son", $clases[1]->get_name() );
        // nombre clase que extiende segunda clase
        $this->assertEquals( "father", $clases[1]->get_extends() );
        // nombre interface que implementa sgunda clase
        $this->assertEquals( "sarasa_interface", $clases[1]->get_implements()[0] );
        
        
    }

    function test_lista_nodos_vacia() {
        $classtree = new ClassTree();
        
        $nodos = $classtree->get_nodos();
        
        $this->assertEquals( 0 , count( $nodos ) );
    }
    
    function test_lista_nodos_1() {
        $path = "/home/rudy/projects/classtree/tests/dummy/prueba2.php";
        
        $classtree = new ClassTree();
        
        $classtree->construir_desde_archivo( $path );
        
        $nodos = $classtree->get_nodos();
        
        $this->assertEquals( 0 , count( $nodos ) );
        
        
    }
    
    
    
    

}

