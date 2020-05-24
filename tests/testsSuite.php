<?php
require_once 'src/includes.php';
include_project_files("./");

/*
 * TESTS !!!
 */
require_once 'tests/microtests/filesTest.php';

require_once 'tests/parameter_Test.php';
require_once 'tests/function_Test.php';
require_once 'tests/class_Test.php';
require_once 'tests/class_finder_Test.php';

require_once 'tests/trees_Test.php';

require_once 'tests/gridTest.php';

require_once 'tests/AppTest.php';



class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        $this->addTestSuite('filesTest');
        
        $this->addTestSuite('function_Test');
        $this->addTestSuite('class_Test');
        $this->addTestSuite('class_finder_Test');


        
        $this->addTestSuite('trees_Test');
        
//         $this->addTestSuite('gridTest');

        
        $this->addTestSuite('AppTest');
        
    }

    public static function suite() {
        return new self();
    }
}

