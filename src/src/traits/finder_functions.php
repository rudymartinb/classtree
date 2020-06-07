<?php
namespace src;

use src\function_finder;

trait finder_functions {
	/*
	 * functions section:
	 * it should create a private function finder object
	 * apply it to the body source
	 */
	private $function_finder;
	function more_functions() : bool {
		if( $this->function_finder === null ){
			$body = $this->get_body();
			$this->function_finder = new function_finder($body);
			
		}
		
		return $this->function_finder->more_elements();
	}
	
	function get_function_name() : string {
		return $this->function_finder->get_name();
	}
	function next_function(){
		return $this->function_finder->next();
	}
	
	// function parameters section
	function more_parameters() : bool {
		return $this->function_finder->more_parameters();
	}
	function get_parameter_name() : string {
		return $this->function_finder->get_parameter_name();
	}
	function get_parameter_type() : string {
		return $this->function_finder->get_parameter_type();
	}
	function get_function_return_type() : string {
		return $this->function_finder->get_return_type();
	}
	function get_function_static() : string {
		return $this->function_finder->get_static();
	}
	function get_function_keyword() : string {
		return $this->function_finder->get_access();
	}
	
	function next_parameter(){
		return $this->function_finder->next_parameter();
	}
	
	
}