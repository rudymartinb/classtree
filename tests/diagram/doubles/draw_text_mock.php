<?php

use diagram\draw_text;

class DrawTextMock extends draw_text {
	
	function __construct( string $text, int $width, int $height ) {
		$this->text = $text;
		$this->height_px = $height;
		$this->width_px = $width;
	}
	
// 	public function get_width(): int {
// 	}

// 	public function get_height(): int {
// 	}

	
}