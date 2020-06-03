<?php
use diagram\component;
use diagram\draw_text;

class DrawTextMock extends draw_text implements component {
	
	function __construct( string $text, int $width, int $height ) {
		$this->text = $text;
		$this->height = $height;
		$this->width = $width;
	}
	
// 	public function get_width(): int {
// 	}

// 	public function get_height(): int {
// 	}

	
}