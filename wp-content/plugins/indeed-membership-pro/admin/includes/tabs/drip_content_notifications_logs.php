<?php
$type = 'drip_content_notifications';
$offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;
$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 0;
//$uid = (isset($_GET['uid'])) ? $_GET['uid'] : 0;
$uid = -1;
$count = Ihc_User_Logs::get_count_logs($type, $uid);
?>
<?php if ($count):?>
	<h3><?php echo __('Drip Content Notifications Logs', 'ihc');?></h3>
	<?php
		$url = admin_url('admin.php?page=ihc_manage&tab=view_drip_content_notifications_logs');
		$limit = 25;
		$current_page = (empty($_GET['ihcp'])) ? 1 : $_GET['ihcp'];
		if ($current_page>1){
			$offset = ( $current_page - 1 ) * $limit;
		} else {
			$offset = 0;
		}
		if ($offset && ($offset + $limit>$count)){
			$limit = $count - $offset;
		}
		//$limit = 25;
		include_once IHC_PATH . 'classes/Ihc_Pagination.class.php';
		$pagination = new Ihc_Pagination(array(
												'base_url' => $url,
												'param_name' => 'ihcp',
												'total_items' => $count,
												'items_per_page' => 25,
												'current_page' => $current_page,
		));
		$pagination = $pagination->output();
		$data = Ihc_User_Logs::get_logs($type, $uid, $offset, $limit);
	?>	
	<?php if ($pagination) echo $pagination;?>	
	<div class="ihc-stuffbox">
		<table class="wp-list-table widefat fixed tags">
			<thead>
				<tr>
					<th class="manage-column" style="width: 55%"><?php _e('Message', 'ihc');?></th>
					<th class="manage-column" style="width: 45%"><?php _e('Date', 'ihc');?></th>
				</tr>
			</thead>
			<tbody>
		<?php $i = 1;?>
		<?php foreach ($data as $array_item):?>
			<tr class="<?php if ($i%2==0) echo 'alternate';$i++;?>">
				<td><?php echo $array_item['log_content'];?></td>
				<td><?php echo date('d-m-Y H:i:s', (int)$array_item['create_date']);?></td>
			</tr>
		<?php endforeach;?>			
			</tbody>
	
		</table>	
	</div>
<?php else: ?>
	<h4><?php _e('No Reports available.', 'ihc');?></h4>
<?php endif;?>


