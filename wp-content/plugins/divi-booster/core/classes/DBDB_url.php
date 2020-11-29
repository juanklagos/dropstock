<?php
class DBDB_url {
 
	// URL will be stored in parse_url() return format
	private $url = array(); 
 
	function __construct($url_string) {
		$this->setUrl($url_string);
	}
	
	function parts() {
		return $this->url;
	}
	
	function path() {
		return isset($this->url['path'])?$this->url['path']:'';
	}
	
	function setPath($path) {
		$this->url['path'] = $path;
		return $this;
	}
	
	function url() {
		$url = $this->url;
		$scheme   = isset($url['scheme']) ? $url['scheme'] . '://' : '';
		$host     = isset($url['host']) ? $url['host'] : '';
		$port     = isset($url['port']) ? ':' . $url['port'] : '';
		$user     = isset($url['user']) ? $url['user'] : '';
		$pass     = isset($url['pass']) ? ':' . $url['pass']  : '';
		$pass     = ($user || $pass) ? "$pass@" : '';
		$path     = isset($url['path']) ? $url['path'] : '';
		$query    = isset($url['query']) ? '?' . $url['query'] : '';
		$fragment = isset($url['fragment']) ? '#' . $url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}	
	
	function setUrl($url_string) {
		$this->url = parse_url($url_string);
	}
}