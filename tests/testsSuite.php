<?php
require_once 'src/includes.php';
include_project_files("./");

/*
 * TESTS !!!
 */
require_once 'tests/microtests/preg_match_all_Test.php';
require_once 'tests/microtests/preg/discard_Test.php';
require_once 'tests/microtests/filesTest.php';

require_once 'tests/parameter_Test.php';
require_once 'tests/function_Test.php';
require_once 'tests/class_Test.php';
require_once 'tests/class_finder_Test.php';
require_once 'tests/namespace_finder_Test.php';
require_once 'tests/trait_finder_Test.php';

require_once 'tests/trees_Test.php';

require_once 'tests/gridTest.php';

require_once 'tests/AppTest.php';


/*
 * the following file is intended to test 
 * how things work in php
 * just write anything that might seems valid on it
 * and remember to delete it once done.
 */
require_once 'tests/microtests/syntax.php';


class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        $this->addTestSuite('preg_match_all_Test');
        $this->addTestSuite('discard_Test');
        
        $this->addTestSuite('namespace_finder_Test');
        $this->addTestSuite('class_finder_Test');
        $this->addTestSuite('trait_finder_Test');
        
        
        $this->addTestSuite('filesTest');
//         $this->addTestSuite('function_Test');
//         $this->addTestSuite('class_Test');


        
//         $this->addTestSuite('trees_Test');
        
//         $this->addTestSuite('gridTest');

        
//         $this->addTestSuite('AppTest');
        
    }

    public static function suite() {
        return new self();
    }
}

