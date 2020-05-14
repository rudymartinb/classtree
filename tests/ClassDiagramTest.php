<?php
use function files\get_all_files;
use function files\get_source;
use function files\get_sources;
use src\ClassDiagram;
use src\clase;

// use src\clase;
// use src\ClassDiagram;

class ClassDiagramTest extends PHPUnit\Framework\TestCase {

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
        $source = get_source_prueba2();
        $classes = get_clases( $source );
        return $classes;
    }
    
    function generate_2_class() : Array {
        $source = get_source_prueba();
        $classes = get_clases( $source );
        return $classes;
    }
    function generate_1_separated_classes() : Array {
        $source2 = get_source_prueba2_2();
        $classes2 = get_clases( $source2 );
        return $classes2;
    }


    
    function test_is_resolved(){
        $diagram = new ClassDiagram();
        
        $class = new clase("parent");
        $diagram->addClass( $class );
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_parent( $diagram->get_classes() );
        
        $this->assertTrue( $class2->is_parent_resolved(), "subclass is now linked with parent");
    }
    
    function test_is_resolved_and_same_obj(){
        $diagram = new ClassDiagram();
        
        $class = new clase("parent");
        $diagram->addClass( $class );
        
        $isacopy = $class;
        $fake = new clase("parent");
        
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_parent( $diagram->get_classes() );
        
        $this->assertTrue( $class2->get_parent() === $class, "subclass is now linked with parent");
        $this->assertTrue( $class2->get_parent() === $isacopy, "subclass shoudl be linked with a copy of parent");
        $this->assertFalse( $class2->get_parent() === $fake, "subclass is now linked with parent");
    }
    
    
    function test_is_NOT_resolved_2(){
        $diagram = new ClassDiagram();
        
        //         $class = new clase("parent");
        //         $diagram->addClass( $class );
        
        
        $class2 = new clase("child");
        $diagram->addClass( $class2 );
        $class2->set_extends( "parent" );
        
        $class2->find_parent( $diagram->get_classes() );
        
        $this->assertFalse( $class2->is_parent_resolved(), "subclass is now linked with parent");
    }
    

}

