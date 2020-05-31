<?php
require_once 'src/includes.php';
include_project_files("./");

/* microtests 
 */
require_once 'microtests/preg/preg_match_all_Test.php';
require_once 'microtests/preg/params_Test.php';

require_once 'tests/microtests/filesTest.php';

// todo: review to see if they are still needed


/* test cases
 */
require_once 'tests/parameters_finder_Test.php';

require_once 'tests/function_finder_Test.php';
require_once 'tests/class_finder_Test.php';
require_once 'tests/namespace_finder_Test.php';
require_once 'tests/trait_finder_Test.php';

require_once 'tests/tree2_Test.php';



/*
 * the following file is intended to test 
 * how things work in php
 * just write anything on the file that might seems valid on it
 * and remember to delete it once done.
 */
require_once 'tests/microtests/syntax.php';


class testsSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('testsSuite');
        
        $this->addTestSuite('preg_match_all_Test');
        $this->addTestSuite('parameters_finder_Test');
        
        $this->addTestSuite('namespace_finder_Test');
        $this->addTestSuite('class_finder_Test');
        $this->addTestSuite('trait_finder_Test');
        
        $this->addTestSuite('tree2_Test');
        
        $this->addTestSuite('filesTest');
		$this->addTestSuite('function_finder_Test');
        
    }

    public static function suite() {
        return new self();
    }
}

