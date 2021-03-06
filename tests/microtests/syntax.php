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
namespace src1 {
	class someclass {
		
	}
}

namespace src2 {
	use \src1\someclass as sm1;
	use \src1\someclass as sm2;
	class someclass extends sm1 {
		function one() : sm2{
			
		}
	}
}