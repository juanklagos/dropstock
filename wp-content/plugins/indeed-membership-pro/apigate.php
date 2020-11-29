<?php
if (empty($no_load)){
	require_once '../../../wp-load.php';	
}
require_once IHC_PATH . 'classes/Ihc_API.class.php';
$api = new Ihc_API();
if ($api->is_enabled() && $api->is_safe()){
	return $api->get_result();
} else {
	echo 'Access denied!';
	die();
}
