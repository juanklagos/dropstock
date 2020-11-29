<?php

class DBDBOption016_GallerySizes extends DBDBOption {
		
	protected $option;
	
	public function __construct($option) {
		$this->option = $option;
	}
	
	protected $defaults = array(
		'imagewidth' => 225,
		'imageheight' => 169,
		'imagescount' => 4
	);
	
	public function imageWidthPx() {
		return $this->filter_int('imagewidth');
	}
	
	public function imageWidthPxDefault() {
		return $this->defaults['imagewidth'];
	}
	
	public function imageHeightPx() {
		return $this->filter_int('imageheight');
	}	
	
	public function imageHeightPxDefault() {
		return $this->defaults['imageheight'];
	}
	
	public function imagesPerRow() {
		return $this->filter_int('imagescount');
	}
	
	public function imagesPerRowDefault() {
		return $this->defaults['imagescount'];
	}
	
	public function filter_int($key) {
		$default = $this->getDefault($key);
		$option = wp_parse_args(
			$this->option, 
			array($key => $default)
		);
		return filter_var($option[$key], FILTER_VALIDATE_INT, array(
			"options" => array(
				'min_range' => 1, 
				'default' => $default
			)
		));
	}
	
	protected function getDefault($key) {
		return isset($this->defaults[$key])?$this->defaults[$key]:null;
	}
}