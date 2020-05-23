<?php

use src\class_;
use function files\get_source;
use function files\get_clases;
use src\class_finder;


function get_between_strings( string $source, string $string1, string $string2 ) : string {
    $strpos1 = strpos($source, $string1 )+strlen($string1);
    $strpos2 = strpos($source, $string2 );
    return substr($source, $strpos1, $strpos2-$strpos1 );
}

function extract_functions( string $source ) : Array {
    $pattern  = "/^";
    $pattern .= "(";
    $pattern .= "(?:[ ]*)";
    $pattern .= "(?<fnmod>(static|private|public|final|))";
    $pattern .= "(?:[ ]*)";
    $pattern .= "(?<fntag>function)";
    $pattern .= "(?:[ ]*)";
    $pattern .= "(?<fnname>[0-9a-zA-Z_]+)[ ]*\(";
    $pattern .= "(?<fnparams>[0-9a-zA-Z_\$ ,]*|)[ ]*\)";
    $pattern .= "(?<fnret>[ ]*\:[ ]*[0-9a-zA-Z_]*[ ]*|)";
    $pattern .= ")";
    $pattern .= "/m";
    
    $finder = new class_finder();
    $finder->set_pattern($pattern);
    $matches = $finder->matches( $source );
    return $matches;
}

class class_Test extends PHPUnit\Framework\TestCase {

    function test_between_strings(){
        $source = "ABCD 123456789 DEFG";
        $this->assertEquals(" 123456789 ", get_between_strings($source, "ABCD", "DEFG"));
    }

    function test_class_1(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
//                 var_dump( $matches );
        $classes = $finder->separar_clases();
        
        $class = $classes[0];
        $this->assertEquals( 'father', trim( $matches["nombretipo"][2] ) );
        
    }
    function test_class_body_grep(){
        $source = '{
    function algo1( int $uno, string $dos ): string 
    {
        
    }
    // comment to be removed
    function algo2( int $uno, string $dos ) {
    }
    /* another comment
     *
    */
    public function algo3( ) : bool {
    }
    final function algo4( ) {
    }
}
';
        
        $matches = extract_functions($source);
//         var_dump( $matches );
        
        $this->assertEquals( 'function algo1( int $uno, string $dos ): string', trim( $matches[0][0] ) );
        $this->assertEquals( 4, trim( count( $matches[0] ) ) );
        
    }

    function test_static_private_functions(){
        $source = '{
    private function algo1( int $uno, string $dos ): string {
            
    }
    // comment to be removed
    static function algo2( int $uno, string $dos ) {
    }
    /* another comment
     *
    */
    function algo3( ) : bool {
    }
    function algo4( ) {
    }
}
';
        $matches = extract_functions($source);
        //         var_dump( $matches[0] );
        
        $this->assertEquals( 'private function algo1( int $uno, string $dos ): string', trim( $matches[0][0] ) );
        $this->assertEquals( 'static function algo2( int $uno, string $dos )', trim( $matches[0][1] ) );
        
    }
    
    
    function test_interface_body(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $pattern  = "/^(?<este>";
        $pattern .= "([ ]*(?<nsflag>namespace)[ ]*";
        $pattern .= "(?<nsname>[0-9a-zA-Z_\\\\]+)[ ]*;";
        $pattern .= ")|";
        $pattern .= "([ ]*(?<ifflag>interface)[ ]*";
        $pattern .= "(?<interface>[0-9a-zA-Z_]+)[ ]*{";
        $pattern .= "(?<ifbody>[^}]*)}";
        $pattern .= ")|(";
        $pattern .= "(?<final>final|)(?<abstract>abstract|)[ ]*(?<tipo>class(?: ))[ ]*";
        $pattern .= "(?<nombretipo>[0-9a-zA-Z_]+)[ ]*";
        $pattern .= "(implements (?<implements>[0-9a-zA-Z_, ]*)|)[ ]+";
        $pattern .= "(extends (?<extends>[0-9a-zA-Z_,]*)|)[ ]*";
        
//         $pattern .= "(";
//         $pattern .= "(?:[ ]*)";
//         $pattern .= "(?<fnmod>(static|private|public|))";
//         $pattern .= "(?:[ ]*)";
//         $pattern .= "(?<fntag>function)";
//         $pattern .= "(?:[ ]*)";
//         $pattern .= "(?<fnname>[0-9a-zA-Z_]+)[ ]*\(";
//         $pattern .= "(?<fnparams>[0-9a-zA-Z_\$ ,]*|)[ ]*\)";
//         $pattern .= "(?<fnret>[ ]*\:[ ]*[0-9a-zA-Z_]*[ ]*|)";
//         $pattern .= ")";
        
        $pattern .= "))/m";

        $finder = new class_finder();
        $finder->set_pattern($pattern);
        $matches = $finder->matches($source );
        

        $class1 = $matches[0][2];
        $class2 = $matches[0][3];
//         var_dump( $matches[0] );
        

        $this->assertTrue( true );
    }

    function test_from_source(){
        $filename = "./tests/dummy/prueba.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        $matches = $finder->matches($source );

//         var_dump($matches);
        
        $classes = $finder->separar_clases();
        
        $this->assertEquals( "interface sarasa_interface {", $matches[0][1] );
        $this->assertEquals( 4, count( $classes ) );
        $this->assertEquals( "interface", $classes[0]->get_type() );
//         var_dump( $classes[0] );
    }
    
    
    function test_class_namespace(){
        $filename = "./tests/dummy/prueba2.php";
        $source = get_source( $filename );
        
        $finder = new class_finder();
        
        $matches = $finder->matches($source );
        //         var_dump( $matches );
        $classes = $finder->separar_clases();
        $this->assertEquals( "class", $classes[0]->get_type() );
        $this->assertEquals( "whats\\is\\this", $classes[0]->get_namespace() );
        
        
    }
    
    /* interfaces
     * 
     */
    function test_class_interface_extends_null() {
        $class = new class_("myinterface");
        $class->set_implements("");
        $this->assertEquals( [""], $class->get_implements() );
    }

    function test_class_extends_2() {
//         $class1 = new class_("parent1");
//         $class2 = new class_("parent1");
        $class3 = new class_("child1");
        $class3->set_extends("parent1");
        $class3->set_extends("parent2");
        
        $this->assertEquals( ["parent1","parent2"], $class3->get_extends() );
    }
    
    
    function test_class_interface_extends_2() {
        $class = new class_("myinterface");
        $class->set_implements("iface1,iface2");
        $this->assertEquals( ["iface1","iface2"], $class->get_implements() );
    }
    
    
    
    
}

