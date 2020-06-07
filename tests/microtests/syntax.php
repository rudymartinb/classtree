<?php
/* this file is just a playground for php syntax check.
 * 
 * just write anything that might seems valid on it
 * and remember to delete it the content once done.
 * (that is, as long as it's inside functions or classes,
 * you don't want weird code to be executed while running tests,
 * so be careful) 
 * 
 * saving the file while running the runtests.sh on script directory
 * will tell you inmediatly if it's valid or not.
 * 
 * since it loads from the test suite 
 * it won't affect the production code.
 * 
 * again, just be careful about what you do.
 * 
 */
namespace sarasa {
	interface if1 {
		
	}
	interface someinterface extends if1 {
		function fn1();
		static function fn2( int $something, string $strong );
		function fn3() : string ;
	}
	
	class sarasa {
	final static private function sarsa() { return ; }
	}
}
