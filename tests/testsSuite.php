<?php
require_once 'src/nodo.php';
require_once 'src/clase.php';
require_once 'src/classtree.php';
require_once 'src/permutacion.php';
require_once 'tests/classtreeTest.php';
require_once 'tests/nodosTest.php';
require_once 'tests/combinatoriaTest.php';

class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
//         $this->addTestSuite('classtreeTest');
//         $this->addTestSuite('nodosTest');
        $this->addTestSuite('combinatoriaTest');
    }

    public static function suite() {
        return new self();
    }
}

