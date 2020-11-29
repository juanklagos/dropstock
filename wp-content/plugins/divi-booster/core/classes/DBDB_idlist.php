<?php
class DBDB_idlist {
 
	private $ids = array();
 
	function __construct() {
	}
	
	function set_ids_from_comma_separated_str($str) {
		$ids = explode(',', $str);
		foreach($ids as $id) {
			$this->add_id($id);
		}
	}
	
	function add_id($id) {
		$this->ids[] = intval(trim($id));
	}
 
	function ids() {
		return $this->ids;
	} 
}