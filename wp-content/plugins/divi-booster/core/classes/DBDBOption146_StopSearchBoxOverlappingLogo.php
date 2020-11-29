<?php

class DBDBOption146_StopSearchBoxOverlappingLogo extends DBDBOption {
	
	protected $slug = '146-stop-search-box-overlapping-logo-on-mobile';
	protected $title = 'Stop search box from overlapping logo';
	
	public function __construct() {
	}
	
	public function settingsPageSection() {
		return 'header';
	}
	
	public function settingsPageSubsection() {
		return 'header-mobile';
	}
}