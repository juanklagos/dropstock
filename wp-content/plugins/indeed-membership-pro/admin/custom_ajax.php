<?php 
require_once '../../../../wp-load.php';
require_once '../utilities.php';

if (!empty($_GET['term'])){
	if (isset($_GET['woo_type']) && $_GET['woo_type']=='category'){
		$data = Ihc_Db::search_woo_product_cats($_GET['term']);		
	} else {
		$data = Ihc_Db::search_woo_products($_GET['term']);			
	}
	
	if (!empty($data)){
		$i = 0;
		foreach ($data as $k=>$v){
			$return[$i]['id'] = $k;
			$return[$i]['label'] = $v;
			$i++;
		}
		echo json_encode($return);
	}
}

die();