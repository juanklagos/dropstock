<?php
ihc_save_update_metas('reason_for_cancel');//save update metas
$data['metas'] = ihc_return_meta_arr('reason_for_cancel');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

$reasonDbObject = new \Indeed\Ihc\Db\ReasonsForCancelDeleteLevels();
$count = $reasonDbObject->count();
$limit = 30;

$current_page = (empty($_GET['p'])) ? 1 : $_GET['p'];
if ( $current_page>1 ){
	$offset = ( $current_page - 1 ) * $limit;
} else {
	$offset = 0;
}
require_once IHC_PATH . 'classes/Ihc_Pagination.class.php';
$url  = admin_url( 'admin.php?page=ihc_manage&tab=reason_for_cancel' );
$pagination_object = new Ihc_Pagination(array(
											'base_url'             => $url,
											'param_name'           => 'p',
											'total_items'          => $count,
											'items_per_page'       => $limit,
											'current_page'         => $current_page,
));
$pagination = $pagination_object->output();
if ( $offset + $limit>$count ){
	$limit = $count - $offset;
}

$items= $reasonDbObject->get( $limit, $offset );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Ultimate Membership Pro - Reason for cancel/delete level', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Reason for cancel/delete level', 'ihc');?></h2>
				<p><?php //_e('', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_reason_for_cancel_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_reason_for_cancel_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_reason_for_cancel_enabled" value="<?php echo $data['metas']['ihc_reason_for_cancel_enabled'];?>" id="ihc_reason_for_cancel_enabled" />
			</div>

			<div class="iump-form-line">
					<label><?php _e('Predefined values', 'ihc');?></label>
					<div>
							<textarea style="width: 90%; height: 200px;" name="ihc_reason_for_cancel_resons"><?php echo stripslashes($data['metas']['ihc_reason_for_cancel_resons']);?></textarea>
					</div>
					<p><?php _e("Write values separated by comma ','.", 'ihc');?></p>
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>

<?php if ( $items ):?>
<table class="wp-list-table widefat fixed tags">
    <thead style="background: #f1f4f8 !important;    border-bottom: 1px solid #ccc;box-shadow: inset 0px -5px 10px 2px rgba(0,0,0,0.03); line-height: 1.4;">
      <tr>
          <td style="width: 20%;font-weight:bold;font-family: 'Oswald', arial, sans-serif !important;padding: 16px 12px;"><?php _e( 'Username', 'ihc' );?></td>
          <td style="width: 20%;font-weight:bold;font-family: 'Oswald', arial, sans-serif !important;padding: 16px 12px;"><?php _e( 'Level', 'ihc' );?></td>
          <td style="width: 20%;font-weight:bold;font-family: 'Oswald', arial, sans-serif !important;padding: 16px 12px;"><?php _e( 'Action', 'ihc' );?></td>
          <td style="width: 30%;font-weight:bold;font-family: 'Oswald', arial, sans-serif !important;padding: 16px 12px;"><?php _e( 'Reason', 'ihc' );?></td>
          <td style="width: 10%;font-weight:bold;font-family: 'Oswald', arial, sans-serif !important;padding: 16px 12px;"><?php _e( 'Date', 'ihc' );?></td>
      </tr>
    </thead>
    <tbody class="ihc-alternate">
        <?php foreach ( $items as $itemData ):?>
            <tr>
                <td><?php echo $itemData->user_login;?></td>
                <td><?php echo \Ihc_Db::get_level_name_by_lid( $itemData->lid );?></td>
                <td><?php echo $itemData->reason;?></td>
                <td><?php echo $itemData->action_type;?></td>
                <td><?php echo date( 'Y-m-d h:i:s', $itemData->action_date );?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php endif;?>

<?php if ($pagination):?>
    <?php echo $pagination;?>
<?php endif;?>

<?php
