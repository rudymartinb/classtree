<?php



class classtreeTest extends PHPUnit\Framework\TestCase {
    /*
     * esta prueba no tendria que existir
     * 
     */
    function test_get_clases() {
        $path = "/home/rudy/projects/classtree/tests/dummy/";

        $classtree = new ClassTree();

        $classtree->construir( $path );
        
        $clases = $classtree->get_clases();
        // nombre primera clase
        $this->assertEquals( "father", $clases[0]->get_nombre() );
//         $funciones = $clases[0]->get_funciones();
//         $nombre = $funciones[0]->get_nombre();
//         $this->assertEquals( "father", $nombre );

        $funciones = $classtree->get_funciones("/home/rudy/projects/classtree/tests/dummy/prueba.php", "father");
        $actual = $funciones["nombretipo"][0];
//         var_dump( $funciones[0] );
        $this->assertEquals("algo1", $actual);
        
        // nombre segunda clase
        $this->assertEquals( "son", $clases[1]->get_nombre() );
        // nombre clase que extiende segunda clase
        $this->assertEquals( "father", $clases[1]->get_extends() );
        // nombre interface que implementa sgunda clase
        $this->assertEquals( "sarasa_interface", $clases[1]->get_implements()[0] );
        
        // namespace
//         $this->assertEquals( "something", $clases[0]->get_namespace() );
        
    }

    function test_lista_nodos_vacia() {
//         $path = "/home/rudy/projects/classtree/tests/dummy/";
        
        $classtree = new ClassTree();
        
        // $classtree->construir( $path );
        
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
    
    
//     function test_namespace() {
//         $filename = "/home/rudy/projects/isft130/src/domain/Alumno.php";
//         $this->assertEquals( "src\\domain", ClassTree::myget_namespace($filename) );
//     }
    
    
//     function test_class_implements() { 
//         $filename = "/home/rudy/projects/isft130/src/domain/Alumno.php";
//         $this->assertEquals( "alumno_interface", myget_class_implements($filename) );
//     }
//     function test_class_extends_implements() {
//         $filename = "/home/rudy/projects/isft130/src/usecases/Caso01_RegistracionUsuario.php";
//         $this->assertEquals( "Caso00_ConexionUsuario", myget_class_extends_implements($filename) );
//     }

//     function test_interface_extends() {
//         $filename = "/home/rudy/projects/isft130/src/usecases/Caso01_RegistracionUsuario.php";
//         $this->assertEquals( "presenter_interface", myget_interface_extends($filename) );
//     }

//     function test_extends() {
//         $filename = "/home/rudy/projects/isft130/src/usecases/Caso01_RegistracionUsuario.php";
//         $this->assertEquals( "presenter_interface", myget_extends($filename) );
//     }

//     function test_interface_extends2() {
//         $filename = "/home/rudy/projects/isft130/src/usecases/Caso01_RegistracionUsuario.php";
//         $this->assertEquals( "presenter_interface", myget_interface_extends2($filename) );
//     }
    
    

}

