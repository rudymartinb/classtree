<?php
// use src\clase;
// use src\ClassDiagram;

class classtreeTest extends PHPUnit\Framework\TestCase {

    /* this test uses fixed files on tests/dummy dir
     * adding or removing files will cause this test to fail
     *
     * (yeah I know I should use an string to mock it,
     * may be will do that later)
     */
    
    function test_get_files() {
        $path = "/home/rudy/projects/classtree/tests/dummy";
        $lista = get_all_files( $path );
        $this->assertEquals( 3, count( $lista ) );
    }

    function test_get_source_from_file() {
        $filename = "/home/rudy/projects/classtree/tests/dummy/prueba2.php";
        $lista = get_source( $filename );
        $this->assertTrue( $lista != ""  );
    }
    
    function test_get_sources() {
        $path = "/home/rudy/projects/classtree/tests/dummy";
        $files = get_all_files( $path );
        $sources = get_sources( $files );
        $this->assertEquals( 3, count( $sources ) );
    }


    function generate_1_class() : Array {
        $source = $this->get_source_prueba2();
        $classes = get_clases( $source );
        return $classes;
    }
    
    function generate_2_class() : Array {
        $source = $this->get_source_prueba();
        $classes = get_clases( $source );
        return $classes;
    }
    function generate_1_separated_classes() : Array {
        $source2 = $this->get_source_prueba2_2();
        $classes2 = get_clases( $source2 );
        return $classes2;
    }

    
    function get_source_prueba() : string {
        $source = '<?php
/*
 * codigo de ejemplo usado para alimentar las pruebas unitarias
 * 
 * una vez terminado NO TOCAR !!!
 */
namespace something;

use DateTime;

interface sarasa_interface {
    function algo() : string;
    
}
class father {
    function algo1( int $uno, string $dos ): string {
        
    }
    
    function algo2( int $uno, string $dos ) {
    }
    function algo3( ) : bool {
    }
    function algo4( ) {
    }
}

class son extends father implements sarasa_interface {
    public function algo(): string {
        
    }
    public function algomas(): DateTime {
        
    }
}

class orphan implements sarasa_interface {
    public function algo() : string {
        
    }
}
';
        return $source;
    }
    
    
    
    function get_source_prueba2() : string {
        $source = "<?php
namespace sarasa;
            
class father {
    public function algo(): string {
            
    }
}";
        return $source;
    }
    
    function get_source_prueba2_2() : string {
        $source = "<?php
namespace sarasa;
            
class son extends father {
    public function algo(): string {
            
    }
}";
        return $source;
    }
    
    

}

