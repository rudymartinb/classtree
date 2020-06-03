<?php

use diagram\draw_text;

class DrawTextMock extends draw_text {
	
	function __construct( string $text, int $width, int $height ) {
		$this->text = $text; // is this needed ?
		$this->height_px = $height;
		$this->width_px = $width;
	}
	
	
}