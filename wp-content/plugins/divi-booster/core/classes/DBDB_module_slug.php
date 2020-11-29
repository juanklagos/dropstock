<?php
class DBDB_module_slug {
 
	public static function is_portfolio($slug) {
		return in_array($slug, array('et_pb_portfolio', 'et_pb_filterable_portfolio', 'et_pb_fullwidth_portfolio'));
	}
}