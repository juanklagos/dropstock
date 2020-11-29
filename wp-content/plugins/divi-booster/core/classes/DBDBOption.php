<?php

class DBDBOption {
	
	protected $slug = '';
	protected $title = '';
	
	public static function getOption($slug) {
		if ($slug === '146-stop-search-box-overlapping-logo-on-mobile') {
			return new DBDBOption146_StopSearchBoxOverlappingLogo();
		}
		return new DBDBOption($slug);
	}
	
	public function __construct($slug) {
		$this->slug = $slug;
	}
	
	public function name($property=false) {
		return 'wtfdivi[fixes]['.$this->slug().']'.($property?"[{$property}]":'');
	}
	
	public function docUrl() {
		return false;
	}
	
	public function title() {
		return $this->title;
	}
	
	public function slug() {
		return $this->slug;
	}
	
	public function settingsPageClass() {
		return 'dbdb-setting_'.$this->slug();
	}
	
}