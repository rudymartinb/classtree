<?php
require_once 'src/includes.php';
include_project_files("./");

/*
 * TESTS !!!
 */
require_once 'tests/mocks/sources.php';
require_once 'tests/microtests/filesTest.php';

require_once 'tests/claseTest.php';
// require_once 'tests/interfaceTest.php';
// require_once 'tests/interfacesTreeTest.php';

require_once 'tests/treeTest.php';

require_once 'tests/gridTest.php';

require_once 'tests/AppTest.php';
require_once 'tests/textoutputTest.php';


class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        $this->addTestSuite('filesTest');
        
        $this->addTestSuite('claseTest');


        
        $this->addTestSuite('treeTest');
        
        $this->addTestSuite('gridTest');

        
        $this->addTestSuite('AppTest');
        
//         $this->addTestSuite('textoutputTest');

        //         $this->addTestSuite('interfaceTest');
        //         $this->addTestSuite('interfacesTreeTest');
        
    }

    public static function suite() {
        return new self();
    }
}

