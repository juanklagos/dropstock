<?php
if (!class_exists('DBDB_color')) {
	class DBDB_color {
	 
		private $red = 0; // 0-255
		private $blue = 0; // 0-255
		private $green = 0; // 0-255
		private $opacity = 1.0; // 0-1
	 
		function __construct($color, $opacity=1.0) {
			
			// Hex
			if (isset($color[0]) && $color[0]==='#') {
				$hex_color = substr($color, 1);
				
				// #ffffff format
				if (strlen($hex_color) === 6) { 
					list($r, $g, $b) = str_split($hex_color, 2); 
					$this->red = hexdec($r);
					$this->green = hexdec($g);
					$this->blue = hexdec($b);
				} 
				
				#fff format
				if ( strlen( $hex_color ) === 3 ) { 
					list($r, $g, $b) = str_split($hex_color, 1); 
					$this->red = hexdec($r.$r);
					$this->green = hexdec($g.$g);
					$this->blue = hexdec($b.$b);
				} 
			}
			
			// Opacity
			$this->opacity = $opacity;
		}
		
		function red() {
			return intval($this->red);
		}
		
		function green() {
			return intval($this->green);
		}
		
		function blue() {
			return intval($this->blue);
		}
		
		function opacity() {
			return floatval($this->opacity);
		}
		
		function rgba_str() {
			return sprintf('rgba(%d, %d, %d, %f)', 
				$this->red(),
				$this->green(),
				$this->blue(),
				$this->opacity()
			);
		}
	}
}