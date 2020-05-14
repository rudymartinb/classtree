<?php
require_once 'src/files.php';

require_once 'src/node.php';
// require_once 'src/tree.php';
require_once 'src/clase.php';
// require_once 'src/classtree.php';
require_once 'src/ClassDiagram.php';

// require_once 'src/permutacion.php';

/*
 * TESTS !!!
 */
require_once 'tests/mocks/sources.php';
require_once 'tests/nodeTest.php';
require_once 'tests/claseTest.php';
require_once 'tests/ClassDiagramTest.php';

// require_once 'tests/treeTest.php';

require_once 'tests/permutationTest.php';

class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        
        $this->addTestSuite('claseTest');
        $this->addTestSuite('ClassDiagramTest');
//         $this->addTestSuite('nodeTest');
//         $this->addTestSuite('treeTest');
//         $this->addTestSuite('combinatoriaTest');
    }

    public static function suite() {
        return new self();
    }
}

