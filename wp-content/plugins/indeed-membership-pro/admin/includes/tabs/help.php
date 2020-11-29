<?php $disabled = (ihc_is_curl_enable()) ? 'disabled' : '';?>
<?php do_action( "ihc_admin_dashboard_after_top_menu" );?>
<?php
$responseNumber = isset($_GET['response']) ? $_GET['response'] : false;
if ( !empty($_GET['token'] ) && $responseNumber == 1 ){
		$ElCheck = new \Indeed\Ihc\Services\ElCheck();
		$responseNumber = $ElCheck->responseFromGet();
}
if ( $responseNumber !== false ){
		$ElCheck = new \Indeed\Ihc\Services\ElCheck();
		$responseMessage = $ElCheck->responseCodeToMessage( $responseNumber, 'ihc-danger-box', 'ihc-success-box', 'ihc' );
}
$license = get_option('ihc_license_set');
$envato_code = get_option('ihc_envato_code');
?>

<div style="width: 97%">
	<div class="ihc-dashboard-title">
		Ultimate Membership Pro -
		<span class="second-text">
			<?php _e('Help Section', 'ihc');?>
		</span>
	</div>


	<div class="metabox-holder indeed">
		<div class="ihc-stuffbox">
			<h3>
				<label style=" font-size:16px;">
					<?php _e('Activate Ultimate Membership Pro', 'ihc');?>
				</label>
			</h3>
			<form method="post" action="">
				<div class="inside">
					<?php if ($disabled):?>
						<div class="iump-form-line iump-no-border" style="font-weight: bold; color: red;"><?php _e("cURL is disabled. You need to enable if for further activation request.")?></div>
					<?php endif;?>
					<div class="iump-form-line iump-no-border" style="width:10%; float:left; box-sizing:border-box; text-align:right; font-weight:bold;">
						<label for="tag-name" class="iump-labels" style="text-align: left;"><?php _e('Purchase Code', 'ihc');?></label>
					</div>
					<div class="iump-form-line iump-no-border" style="width:70%; float:left; box-sizing:border-box;">
						<input name="ihc_licensing_code_v2" type="password" value="<?php echo $envato_code;?>" style="width:100%;"/>
					</div>

					<div class="ihc-stuffbox-submit-wrap iump-submit-form" style="width:20%; float:right; box-sizing:border-box;">
						<?php if ( $license ):?>
		            <div class="ihc-revoke-license ihc-js-revoke-license"><?php _e( 'Revoke License', 'ihc' );?></div>
		        <?php else: ?>
								<input type="submit" value="<?php _e('Activate License', 'ihc');?>" name="ihc_save_licensing_code" <?php echo $disabled;?> class="button button-primary button-large" />
		        <?php endif;?>
					</div>

					<div class="ihc-clear"></div>

					<div class="ihc-license-status">
		        	<?php
								if ( $responseNumber !== false ){
										echo $responseMessage;
								} else if ( !empty( $_GET['revoke'] ) ){
										?>
										<div class="ihc-success-box"><?php _e( 'You have just revoke your license for Ultimate Membership Pro plugin.', 'ihc' );?></div>
										<?php
								} else if ( $license ){ ?>
											<div class="ihc-success-box"><?php _e( 'Your license for Ultimate Membership Pro is currently Active.', 'ihc' );?></div>
		          <?php } ?>
		      </div>

					<div class="ihc-license-status">
						<?php
						if ( isset($_GET['extraCode']) && isset( $_GET['extraMess'] ) && $_GET['extraMess'] != '' ){
								$_GET['extraMess'] = stripslashes($_GET['extraMess']);
								if ( $_GET['extraCode'] > 0 ){
										// success
										?>
										<div class="ihc-success-box"><?php echo urldecode( $_GET['extraMess'] );?></div>
										<?php
								} else if ( $_GET['extraCode'] < 0 ){
										// errors
										?>
										<div class="ihc-danger-box"><?php echo urldecode( $_GET['extraMess'] );?></div>
										<?php
								} else if ( $_GET['extraCode'] == 0 ){
										// warning
										?>
										<div class="ihc-warning-box"><?php echo urldecode( $_GET['extraMess'] );?></div>
										<?php
								}
						}
					?>
					</div>

					<div style="padding:0 60px;">
					<p>A valid purchase code Activate the Full Version of<strong> Ultimate Memership Pro</strong> plugin and provides access on support system. A purchase code can only be used for <strong>ONE</strong> Ultimate Membership Pro for WordPress installation on <strong>ONE</strong> WordPress site at a time. If you previosly activated your purchase code on another website, then you have to get a <a href="https://codecanyon.net/item/ultimate-membership-pro-wordpress-plugin/12159253?ref=azzaroco" target="_blank">new Licence</a>.</p>
					<h4>Where can I find my Purchase Code?</h4>
					<a href="https://codecanyon.net/item/ultimate-membership-pro-wordpress-plugin/12159253?ref=azzaroco" target="_blank">
						<img src="<?php echo IHC_URL;?>admin/assets/images/purchase_code.jpg" style="margin: 0 auto; display: block;"/>
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>

<div class="metabox-holder indeed">
	<div class="ihc-stuffbox">
		<h3>
			<label style="text-transform: uppercase; font-size:16px;">
				<?php _e('Contact Support', 'ihc');?>
			</label>
		</h3>
		<div class="inside">
			<div class="submit" style="float:left; width:80%;">
				<?php _e('In order to contact Indeed support team you need to create a ticket providing all the necessary details via our support system:', 'ihc');?> support.wpindeed.com
			</div>
			<div class="submit" style="float:left; width:20%; text-align:center;">
				<a href="http://support.wpindeed.com/open.php?topicId=0" target="_blank" class="button button-primary button-large"> <?php _e('Submit Ticket', 'ihc');?></a>
			</div>
			<div class="clear"></div>
		</div>
	</div>

	<div class="ihc-stuffbox">
		<h3>
			<label style="text-transform: uppercase; font-size:16px;">
		    	<?php _e('Documentation', 'ihc');?>
		    </label>
		</h3>
		<div class="inside">
			<iframe src="https://demoiump.wpindeed.com/documentation/" width="100%" height="1000px" ></iframe>
		</div>
	</div>
</div>
</div>


<script>

jQuery( document ).ready(function(){
				jQuery( '[name=ihc_save_licensing_code]' ).on( 'click', function(){
						jQuery.ajax({
								type : "post",
								url : decodeURI( window.ihc_site_url ) + '/wp-admin/admin-ajax.php',
								data : {
													 action						: "ihc_el_check_get_url_ajax",
													 purchase_code		: jQuery('[name=ihc_licensing_code_v2]').val(),
													 nonce						: '<?php echo wp_create_nonce('ihc_license_nonce');?>',
											 },
								success: function (data) {
										if ( data ){
												window.location.href = data;
										} else {
												alert( 'Error!' );
										}
								}
					 });
						return false;
				});

				jQuery( '.ihc-js-revoke-license' ).on( 'click', function(){
						jQuery.ajax({
									type : "post",
									url : decodeURI( window.ihc_site_url ) + '/wp-admin/admin-ajax.php',
									data : {
													 action						: "ihc_revoke_license",
													 nonce						: '<?php echo wp_create_nonce('ihc_license_nonce');?>',
									},
									success: function (data) {
											window.location.href = '<?php echo admin_url('admin.php?page=ihc_manage&tab=help&revoke=true');?>';
									}
						});
				});

});

</script>
