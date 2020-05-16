<?php
require_once 'src/files.php';

require_once 'src/node.php';
require_once 'src/interface_.php';
require_once 'src/class_.php';
require_once 'src/ClassDiagram.php';

require_once 'src/app.php';

// require_once 'src/permutacion.php';

/*
 * TESTS !!!
 */
require_once 'tests/mocks/sources.php';
require_once 'tests/microtests/filesTest.php';

require_once 'tests/nodeTest.php';
require_once 'tests/claseTest.php';
require_once 'tests/interfaceTest.php';

require_once 'tests/treeTest.php';

// TODO: eliminar?
require_once 'tests/ClassDiagramTest.php';

require_once 'tests/AppTest.php';

// require_once 'tests/permutationTest.php';

class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        $this->addTestSuite('filesTest');
        
        $this->addTestSuite('claseTest');
        $this->addTestSuite('interfaceTest');
        $this->addTestSuite('ClassDiagramTest');
        
        $this->addTestSuite('AppTest');
        
//         $this->addTestSuite('nodeTest');
        $this->addTestSuite('treeTest');
//         $this->addTestSuite('combinatoriaTest');
    }

    public static function suite() {
        return new self();
    }
}

