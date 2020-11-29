<?php

ihc_save_update_metas('direct_login');//save update metas
$data['metas'] = ihc_return_meta_arr('direct_login');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

$items = \Ihc_Db::directLoginGettAllItems();
$url = get_site_url();
if ( substr( $url, -1 ) != '/' ){

    $url .= '/';

}

?>
<div class="iump-wrapper">
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Ultimate Membership Pro - Direct Login', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Direct Login', 'ihc');?></h2>
                <p><?php _e('Users can login without standard credentials but with a special temporary link available. Once the link is used or expire will not be usable anymore. This feature is useful for emergency situations or when user forgot his credentials.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_direct_login_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_direct_login_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>

				<input type="hidden" name="ihc_direct_login_enabled" value="<?php echo $data['metas']['ihc_direct_login_enabled'];?>" id="ihc_direct_login_enabled" />
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>
		</div>
	</div>



  <?php if ($data['metas']['ihc_direct_login_enabled']):?>

    <div class="ihc-stuffbox">
  		<h3 class="ihc-h3"><?php _e('Generate temporary Login links', 'ihc');?></h3>
  		<div class="inside">

          <div class="input-group" style="margin:0px 0 15px 0; max-width:400px;">
              <span class="input-group-addon"><?php _e('Username', 'ihc');?></span>
              <input type="text" id="direct_login_usernmae"  class="form-control" />
          </div>

          <div class="input-group" style="margin:0px 0 15px 0; max-width:400px;">
              <span class="input-group-addon"><?php _e('Timeout', 'ihc');?></span>
              <input type="number" id="direct_login_timeout" min=1  class="form-control"/>
              <div class="input-group-addon"><?php _e('hours', 'ihc');?></div>
          </div>

          <div class="iump-form-line">
              <h2 id="direct_link_value"></h2>
          </div>
          <div class="ihc-submit-form" style="margin-top: 20px;">
            <button class="button button-primary button-large" id="direct_link_generate_link"><?php _e('Generate link', 'ihc');?></button>
          </div>
      </div>
    </div>
  <?php endif;?>

</form>

<?php if ( $items ):?>
<table class="wp-list-table widefat fixed tags ihc-admin-tables" style="margin-right:20px;">
   <thead>
      <tr>
      <th style="width:30%"><?php _e( 'Username', 'ihc' );?></th>
	  <th style="width:50%"><?php _e( 'URL', 'ihc' );?></th>
	  <th style="width:10%"><?php _e( 'Expire', 'ihc' );?></th>
	  <th style="width:10%"><?php _e( 'Action', 'ihc' );?></th>
      </tr>
    </thead>
    <tbody class="ihc-alternate">
        <?php $i = 1;
		foreach ( $items as $itemData ):?>
            <tr class="<?php if($i%2==0) echo 'alternate';?>">
                <td style="color: #21759b; font-weight:bold; width:120px;font-family: 'Oswald', arial, sans-serif !important;font-size: 14px;font-weight: 400;"><?php echo $itemData->user_login;?></td>
                <td><?php echo add_query_arg( array('ihc_action' => 'dl', 'token' => $itemData->token), $url );?></td>
                <td <?php if (indeed_get_unixtimestamp_with_timezone()>$itemData->timeout) echo "style='color: red'";?>><?php echo date( 'Y-m-d h:i:s', $itemData->timeout );?></td>
                <td><i class="fa-ihc ihc-icon-remove-e ihc-pointer ihc-direct-login-remove-item" data-uid="<?php echo $itemData->ID;?>"></i></td>
            </tr>
        <?php $i++;
		endforeach;?>
    </tbody>
</table>
<?php endif;?>

</div>
