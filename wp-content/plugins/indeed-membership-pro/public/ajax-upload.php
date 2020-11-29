<?php
/*
 * Upload files via Ajax
 */

require_once("../../../../wp-load.php");

// security layer
$uid = indeed_get_uid();
$access = true;
if ( !$uid ){
		$hash = isset( $_COOKIE['ihcMedia'] ) ? $_COOKIE['ihcMedia'] : '';
		if ( empty($hash) ){
				$access = false;
		}
		$hash = esc_sql( $hash );
		$exists = \Ihc_Db::doesMediaHashExists( $hash );
		if ( !$exists ){
				$access = false;
		}
}
// end of security layer

if ( $access ){
	if (isset($_FILES['avatar'])){
		//========== handle avatar image
		if ($_FILES['avatar']['type']=='image/png' || $_FILES['avatar']['type']=='image/gif' || $_FILES['avatar']['type']=='image/jpeg'){
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
			$arr['id'] = media_handle_upload('avatar', 0);
			if ($arr['id']){
				$arr['url'] =  wp_get_attachment_url($arr['id']);
				$arr['secret'] = md5($arr['url']);
				echo json_encode($arr);
			} else {
				echo '';
			}
		}
	} else if (isset($_FILES['ihc_file'])){
		//============= handle upload file
		//debug
		//file_put_contents( "upload_media.log", $_FILES['ihc_file']['type'], FILE_APPEND | LOCK_EX );
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		$arr['id'] = media_handle_upload('ihc_file', 0);
		if ($arr['id']){
			$arr['url'] =  wp_get_attachment_url( $arr['id'] );
			$arr['secret'] = md5($arr['url']);
		}

		$arr['name'] = $_FILES['ihc_file']['name'];
		if (in_array($_FILES['ihc_file']['type'], array('image/gif','image/jpg','image/jpeg','image/png'))){
			$arr['type'] = 'image';
		} else {
			$arr['type'] = 'other';
		}
		echo json_encode($arr);
	}

	else if (isset($_FILES['img'])){
			//// upload account page banner
			$cropImage = new Indeed\Ihc\CropImage();
			echo $cropImage->saveImage($_FILES)
										 ->getResponse();
	}

	else if (isset($_POST['imgUrl'])){
			$cropImage = new Indeed\Ihc\CropImage();
			if ( isset($_POST['customIdentificator']) && $_POST['customIdentificator']=='image' ){
					$cropImage->setSaveUserMeta( false );
			}
			echo $cropImage->cropImage($_POST)
										 ->getResponse();
	}
}
