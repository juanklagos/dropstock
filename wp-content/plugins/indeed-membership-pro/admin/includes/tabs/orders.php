<?php
wp_enqueue_script( 'ihc-print-this' );
////////////// create order manually
if (isset($_POST['save_order']) && !empty( $_POST['ihc_admin_add_new_order_nonce'] ) && wp_verify_nonce( $_POST['ihc_admin_add_new_order_nonce'], 'ihc_admin_add_new_order_nonce' ) ){
		require_once IHC_PATH . 'admin/classes/Ihc_Create_Orders_Manually.php';
		$Ihc_Create_Orders_Manually = new Ihc_Create_Orders_Manually($_POST);
		$Ihc_Create_Orders_Manually->process();
		if (!$Ihc_Create_Orders_Manually->get_status()){
				$create_order_message = '<div class="ihc-danger-box">' . $Ihc_Create_Orders_Manually->get_reason() . '</div>';
		} else {
				$create_order_message = '<div class="ihc-success-box">' . __('Order has been created!', 'ihc') . '</div>';
		}
}

if (!empty($_POST['submit_new_payment'])){
	unset($_POST['submit_new_payment']);
	$array = $_POST;
	if (empty($array['txn_id'])){
		/// set txn_id
		$array['txn_id'] = $_POST['uid'] . '_' . $_POST['order_id'] . '_' . indeed_get_unixtimestamp_with_timezone();
	}
	$array['message'] = 'success';


	/// THIS PIECe OF CODE ACT AS AN IPN SERVICE.
	$level_data = ihc_get_level_by_id($_POST['level']);
	if (isset($level_data['access_trial_time_value']) && $level_data['access_trial_time_value'] > 0 && ihc_user_level_first_time($_POST['uid'], $_POST['level'])){
		/// CHECK FOR TRIAL
		ihc_set_level_trial_time_for_no_pay($_POST['level'], $_POST['uid'], TRUE);
	}
	ihc_update_user_level_expire($level_data, $_POST['level'], $_POST['uid']);

	ihc_send_user_notifications($_POST['uid'], 'payment', $_POST['level']);//send notification to user
	ihc_send_user_notifications($_POST['uid'], 'admin_user_payment', $_POST['level']);//send notification to admin
	do_action( 'ihc_payment_completed', $_POST['uid'], $_POST['level'] );
	ihc_switch_role_for_user($_POST['uid']);
	ihc_insert_update_transaction($_POST['uid'], $array['txn_id'], $array);

	Ihc_User_Logs::set_user_id($_POST['uid']);
	Ihc_User_Logs::set_level_id($_POST['level']);
	Ihc_User_Logs::write_log( __('Complete transaction.', 'ihc'), 'payments');

	unset($array);
}
$uid = (isset($_GET['uid'])) ? $_GET['uid'] : 0;

	$data['total_items'] = Ihc_Db::get_count_orders($uid);
	if ($data['total_items']){
		$url = admin_url('admin.php?page=ihc_manage&tab=orders');
		$limit = 25;
		$current_page = (empty($_GET['ihc_payments_list_p'])) ? 1 : $_GET['ihc_payments_list_p'];
		if ($current_page>1){
			$offset = ( $current_page - 1 ) * $limit;
		} else {
			$offset = 0;
		}
		include_once IHC_PATH . 'classes/Ihc_Pagination.class.php';
		$pagination = new Ihc_Pagination(array(
												'base_url' => $url,
												'param_name' => 'ihc_payments_list_p',
												'total_items' => $data['total_items'],
												'items_per_page' => $limit,
												'current_page' => $current_page,
		));
		if ($offset + $limit>$data['total_items']){
			$limit = $data['total_items'] - $offset;
		}
		$data['pagination'] = $pagination->output();
		$data['orders'] = Ihc_Db::get_all_order($limit, $offset, $uid);
	}
	$data['view_transaction_base_link'] = admin_url('admin.php?page=ihc_manage&tab=payments&details_id=');
	$data['add_new_transaction_by_order_id_link'] = admin_url('admin.php?page=ihc_manage&tab=new_transaction&order_id=');

	$payment_gateways = ihc_list_all_payments();

	$show_invoices = (ihc_is_magic_feat_active('invoices')) ? TRUE : FALSE;
	$invoiceShowOnlyCompleted = get_option('ihc_invoices_only_completed_payments');
	require_once IHC_PATH . 'classes/Orders.class.php';
	$Orders = new Ump\Orders();
?>
<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item <?php echo ($_REQUEST['tab'] =='orders') ? 'ihc-subtab-selected' : '';?>" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=orders');?>"><?php _e('Orders', 'ihc');?></a>
	<a class="ihc-subtab-menu-item <?php echo ($_REQUEST['tab'] =='payments') ? 'ihc-subtab-selected' : '';?>" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=payments');?>"><?php _e('Transactions', 'ihc');?></a>
	<div class="ihc-clear"></div>
</div>
<?php
echo ihc_inside_dashboard_error_license();
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<div class="iump-wrapper">
<div class="iump-page-title">Ultimate Membership Pro -
	<span class="second-text"><?php _e('Orders List', 'ihc');?></span>
</div>
<a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=add_new_order');?>" class="indeed-add-new-like-wp">
			<i class="fa-ihc fa-add-ihc"></i><?php _e('Add New Order', 'ihc');?></a>

<?php if (!empty($create_order_message)):?>
		<div style="margin-top: 10px;"><?php echo $create_order_message;?></div>
<?php endif;?>

<?php if (!empty($data['orders'])):?>
	<?php echo $data['pagination'];?>
		<div class="iump-rsp-table">
<table class="wp-list-table widefat fixed tags ihc-admin-tables" style="margin-top:20px;">
	<thead>
		<tr>
			<th class="manage-column" style="width:60px;">
				<span><?php _e('ID', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Code', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Customer', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Items', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Total Amount', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Payment method', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Date', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Coupon', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Transaction', 'ihc');?></span>
			</th>
			<?php if ($show_invoices):?>
				<th class="manage-column">
					<span><?php _e('Invoices', 'ihc');?></span>
				</th>
			<?php endif;?>
			<th class="manage-column">
				<span><?php _e('Status', 'ihc');?></span>
			</th>
			<th class="manage-column" style="width:60px;">
				<span><?php _e('Actions', 'ihc');?></span>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th class="manage-column">
				<span><?php _e('ID', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Code', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Customer', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Items', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Total Amount', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Payment method', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Date', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Coupon', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Transaction', 'ihc');?></span>
			</th>
			<?php if ($show_invoices):?>
				<th class="manage-column">
					<span><?php _e('Invoice', 'ihc');?></span>
				</th>
			<?php endif;?>
			<th class="manage-column">
				<span><?php _e('Status', 'ihc');?></span>
			</th>
			<th class="manage-column">
				<span><?php _e('Actions', 'ihc');?></span>
			</th>
		</tr>
	</tfoot>

	<?php
	$i = 1;
	foreach ($data['orders'] as $array):?>
		<tr  class="<?php if($i%2==0) echo 'alternate';?>">
			<td><?php echo $array['id'];?></td>
			<td><?php
				if (!empty($array['metas']['code'])){
					echo $array['metas']['code'];
				} else {
					echo '-';
				}
			?></td>
			<td><span style="color: #21759b; font-weight:bold;"><?php echo $array['user'];?></span></td>
			<td><div class="level-type-list"><?php echo $array['level'];?></div></td>
			<td><span class="level-payment-list"><?php echo $array['amount_value'] . ' ' . $array['amount_type'];?></span></td>
			<td><?php
				if (empty($array['metas']['ihc_payment_type'])):
					echo '-';
				else:
					if (!empty($array['metas']['ihc_payment_type'])){
						$gateway_key = $array['metas']['ihc_payment_type'];
						echo $payment_gateways[$gateway_key];
					}
				endif;
			?></td>
			<td><?php echo ihc_convert_date_time_to_us_format($array['create_date']);?></td>
			<td><?php
					$coupon = $Orders->get_meta_by_order_and_name($array['id'], 'coupon_used');
					if ($coupon) echo $coupon;
					else echo '-';
			?></td>
			<td><?php
					if (empty($array['transaction_id'])):
						?>
							<a href="<?php echo $data['add_new_transaction_by_order_id_link'] . $array['id'];?>"><?php _e('Add New', 'ihc');?></a>
						<?php
					else :
						?>
							<a href="<?php echo $data['view_transaction_base_link'] . $array['transaction_id'];?>"><?php _e('View', 'ihc');?></a>
						<?php
					endif;
			?></td>
			<?php if ($show_invoices):?>
				<?php if ( !empty( $invoiceShowOnlyCompleted ) && $array['status'] !== 'Completed' ):?>
					<td data-title="<?php _e('Level', 'ihc');?>">-</td>
				<?php else:?>
					<td><i class="fa-ihc fa-invoice-preview-ihc iump-pointer" onClick="iumpGenerateInvoice(<?php echo $array['id'];?>);"></i></td>
				<?php endif;?>
			<?php endif;?>
			<td style="font-weight:700;">
				<?php
					//echo ucfirst($array['status']);
					switch ($array['status']){
						case 'Completed':
							_e('Completed', 'ihc');
							break;
						case 'pending':
							_e('Pending', 'ihc');
							break;
						case 'fail':
						case 'failed':
							_e('Fail', 'ihc');
							break;
						case 'error':
							_e('Error', 'ihc');
							break;
						default:
							echo $array['status'];
							break;
					}
				?>
			</td>
			<td class="column" style="width:60px; text-align:center;">
					<span class="ihc-pointer ihc-js-delete-order" data-id="<?php echo $array['id'];?>">
							<i class="fa-ihc ihc-icon-remove-e"></i>
					</span>
			</td>
		</tr>
	<?php
		$i++;
	 endforeach;?>

</table>
</div>
<?php endif;?>
</div>

<script>
jQuery( '.ihc-js-delete-order' ).on( 'click', function(){
		var orderId = jQuery( this ).attr( 'data-id' );
		swal({
			title: "<?php _e( 'Are you sure that you want to delete this order?', 'ihc' );?>",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
		function(){
				jQuery.ajax({
						type : 'post',
						url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
						data : {
											 action: 'ihc_admin_delete_order',
											 id:			orderId,
									 },
						success: function (response) {
								location.reload();
						}
			 });
	 });
});
</script>

<style>
.btn-default {
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}
.btn-default:focus,
.btn-default.focus {
  color: #333;
  background-color: #e6e6e6;
  border-color: #8c8c8c;
}
.btn-default:hover {
  color: #333;
  background-color: #e6e6e6;
  border-color: #adadad;
}
.btn-default:active,
.btn-default.active,
.open > .dropdown-toggle.btn-default {
  color: #333;
  background-color: #e6e6e6;
  border-color: #adadad;
}
.btn-default:active:hover,
.btn-default.active:hover,
.open > .dropdown-toggle.btn-default:hover,
.btn-default:active:focus,
.btn-default.active:focus,
.open > .dropdown-toggle.btn-default:focus,
.btn-default:active.focus,
.btn-default.active.focus,
.open > .dropdown-toggle.btn-default.focus {
  color: #333;
  background-color: #d4d4d4;
  border-color: #8c8c8c;
}
.btn-default:active,
.btn-default.active,
.open > .dropdown-toggle.btn-default {
  background-image: none;
}
.btn-default.disabled,
.btn-default[disabled],
fieldset[disabled] .btn-default,
.btn-default.disabled:hover,
.btn-default[disabled]:hover,
fieldset[disabled] .btn-default:hover,
.btn-default.disabled:focus,
.btn-default[disabled]:focus,
fieldset[disabled] .btn-default:focus,
.btn-default.disabled.focus,
.btn-default[disabled].focus,
fieldset[disabled] .btn-default.focus,
.btn-default.disabled:active,
.btn-default[disabled]:active,
fieldset[disabled] .btn-default:active,
.btn-default.disabled.active,
.btn-default[disabled].active,
fieldset[disabled] .btn-default.active {
  background-color: #fff;
  border-color: #ccc;
}
.btn-danger:hover{
    color: #fff;
    background-color: #ac2925;
    border-color: #761c19;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}
.btn-lg, .btn-group-lg > .btn {
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.3333333;
    border-radius: 6px;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

</style>
