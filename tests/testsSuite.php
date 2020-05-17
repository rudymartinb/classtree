<?php

/* TODO:
 * separate the src files into another file at the src dir 
 *   
 */
require_once 'src/files.php';
require_once 'src/get_tree.php';
require_once 'src/get_interfaces_tree.php';


require_once 'src/interface_.php';
require_once 'src/class_.php';

require_once 'src/app.php';

/*
 * TESTS !!!
 */
require_once 'tests/mocks/sources.php';
require_once 'tests/microtests/filesTest.php';

require_once 'tests/claseTest.php';
require_once 'tests/interfaceTest.php';

require_once 'tests/treeTest.php';
require_once 'tests/interfacesTreeTest.php';


require_once 'tests/AppTest.php';


class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        $this->addTestSuite('filesTest');
        
        $this->addTestSuite('claseTest');
        $this->addTestSuite('interfaceTest');
        
        $this->addTestSuite('AppTest');
        
        $this->addTestSuite('treeTest');
        $this->addTestSuite('interfacesTreeTest');
        
    }

    public static function suite() {
        return new self();
    }
}

