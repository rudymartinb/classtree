<?php
namespace src;


class class_tree_builder extends tree_builder {

	protected $classes = [] ;

	protected function resolve( string $parent = "" ) : Array {
		$tree = [];
		foreach( $this->classes as $class ){
			$classname = $class["name"];
			$extends = $class["extends"];
			
			if( $parent !== "" ){
				if( $extends != $parent ) {
					continue;
				}
			} else {
				if( $extends !== "" ){
					continue;
				}
			}
			
			$children = $this->resolve( $classname );
			$tree[] = [
					"name" => $classname,
					"extends" => $extends,
					"children" => $children,
					"width" => max( $this->max_width( $children ), 1 ),
					"height" => $this->max_height( $children )+1
			];
		}
		return $tree;
	}


	function add_source( string $source ){
		$nsfinder = new namespace_finder($source);
		while($nsfinder->more_elements()){
			$namespace = $nsfinder->get_name();
			$body = $nsfinder->get_body();
			$this->add_classes( $body, $namespace );
			$nsfinder->next();
		}
	}
	

	private function add_classes( string $source, string $namespace = "" ){
		$finder = new class_finder($source);
		while( $finder->more_elements() ){
			$class = [];
			$class["name"] = $finder->get_name();
			$class["extends"] = $finder->get_extends();
			$class["namespace"] = $namespace;
			
			$class["functions"] = [];
			while( $finder->more_functions() ){
				$func = [ "fnname" => $finder->get_function_name(), "fnretval" => $finder->get_function_return_type(), "params" => [] ];
				while( $finder->more_parameters() ){
					$func["params"][] = [ "param_type" => $finder->get_parameter_type(), "param_name" => $finder->get_parameter_name() ];
					$finder->next_parameter();
				}
				$class["functions"][] = $func;
				$finder->next_function();
			}
			
			$class["usetraits"] = [];
			while( $finder->more_traits() ){
				$class["usetraits"][] = [ "usetrait_name" => $finder->get_trait_name() ];
				$finder->next_trait();
			}
			
			$this->classes[] = $class;
			$finder->next();
		}
	}
}
