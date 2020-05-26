<?php
/* this file is just a playground for php syntax check.
 * 
 * just write anything that might seems valid on it
 * (that is, as long as it's inside functions or classes,
 * you don't want weird code to be executed while running tests) 
 * and remember to delete it the content once done.
 * 
 * saving the file while running the runtests.sh on script directory
 * will tell you inmediatly if it's valid or not.
 * 
 * since it loads from the test suite 
 * it won't affect the production code.
 */

function
weird_function
(
		int $something 
		)
		:
		int
		{
	return
	0
	;
}

function w1(){
	function w2(){
		
	}
}