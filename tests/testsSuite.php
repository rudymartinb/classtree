<?php
require_once 'src/includes.php';
include_project_files("./");

/*
 * the following file is intended to test
 * how things work in php
 * just write anything on the file that might seems valid to you
 * and remember to delete it once done.
 * 
 * I have promoted this line because if there's something wrong
 * I don't want it to interfere with tests
 */
require_once 'tests/microtests/syntax.php';


/* microtests 
 */
require_once 'microtests/preg/preg_match_all_Test.php';
require_once 'microtests/preg/params_Test.php';

require_once 'tests/microtests/filesTest.php';


/* test cases
 */
require_once 'src/parameters_finder_Test.php';

require_once 'src/function_finder_Test.php';
require_once 'src/class_finder_Test.php';
require_once 'src/interface_finder_Test.php';
require_once 'src/namespace_finder_Test.php';
require_once 'src/trait_finder_Test.php';
require_once 'src/usetrait_finder_Test.php';

require_once 'src/tree2_Test.php';



class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        // microtests section
        $this->addTestSuite('preg_match_all_Test');
        $this->addTestSuite('parameters_finder_Test'); 
        $this->addTestSuite('filesTest');
        
        // test cases section
        $this->addTestSuite('namespace_finder_Test');
        $this->addTestSuite('class_finder_Test');
        $this->addTestSuite('interface_finder_Test');
        $this->addTestSuite('trait_finder_Test');
        $this->addTestSuite('usetrait_finder_Test');
        $this->addTestSuite('function_finder_Test');
        
        $this->addTestSuite('tree2_Test');
        
    }

    public static function suite() {
        return new self();
    }
}

