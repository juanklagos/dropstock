<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item <?php echo ($_REQUEST['subtab'] =='settings' || !isset($_REQUEST['subtab'])) ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab='.$tab.'&subtab=settings';?>"><?php _e('Settings', 'ihc');?></a>
	<a class="ihc-subtab-menu-item <?php echo ($_REQUEST['subtab'] =='design') ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab='.$tab.'&subtab=design';?>"><?php _e('Design', 'ihc');?></a>
	<?php
	$arr = array(
			"fb" => "Facebook",
			"tw" => "Twitter",
			"goo" => "Google",
			"in" => "LinkedIn",
			"vk" => "Vkontakte",
			"ig" => "Instagram",
			"tbr" => "Tumblr"
	);
	foreach ($arr as $k=>$v){
		?>
		<a class="ihc-subtab-menu-item" href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item='.$k;?>"><?php echo $v;?></a>
		<?php
	}
	?>
	<div class="ihc-clear"></div>
</div>
<?php
if (empty($_GET['subtab'])){
	$_GET['subtab'] = 'settings';
}
echo ihc_inside_dashboard_error_license();
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

if ($_GET['subtab']=='settings'){
	//===================== SETTINGS PAGE
	if (empty($_GET['item'])){
		////// GENERAL SETTINGS
		?>
			<div class="iump-page-title">Ultimate Membership Pro -
				<span class="second-text">
					<?php _e('Social Media Login', 'ihc');?>
				</span>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("fb"); ?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=fb';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Facebook</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("tw"); ?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=tw';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Twitter</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("goo");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=goo';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Google</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("in"); ?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=in';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">LinkedIn</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("vk");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=vk';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Vkontakte</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("ig");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=ig';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Instagram</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("tbr");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=tbr';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Tumblr</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

		<?php
	} else {
		$callbackURL = IHC_URL . 'public/social_handler.php'; // old was site_url()
		switch ($_GET['item']){
			case 'fb':
				if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
						ihc_save_update_metas('fb');
				}

				$meta_arr = ihc_return_meta_arr('fb');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">

					<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

					<div class="ihc-stuffbox">
						<h3><?php _e('Facebook Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Facebook login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = ($meta_arr['ihc_fb_status']) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_fb_status');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
							</label>
							<input type="hidden" value="<?php echo $meta_arr['ihc_fb_status'];?>" name="ihc_fb_status" id="ihc_fb_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Facebook Settings:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_fb_app_id'];?>" name="ihc_fb_app_id" style="width: 300px;" />
							</div>
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_fb_app_secret'];?>" name="ihc_fb_app_secret" style="width: 300px;" />
							</div>
							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a Facebook App")?></h4></div>


								<ul class="ihc-info-list">
								<li><?php _e("Go to ", "ihc");?><a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a></li>
								<li><?php _e('Look after \'My Apps\' and \'Add a New App\'.', 'ihc');?></li>
								<li><?php _e('After complete the name of the app (make sure not to put facebook or fb in app name) click \'Create App ID\'.', 'ihc');?></li>
								<li><?php _e('In left side area look after \'Settings > Basic\' and fill <b>App Domains</b> with your site domain. (mywebsite.com,  www.mywebsite.com).', 'ihc');?></li>
								<li><?php _e('Go back to your website and create 2 pages with Privacy Policy and Terms of Service. Put their URL\'s in <b>Privacy Policy URL</b> and <b>Terms of Service URL</b> in your Facebook app.', 'ihc');?></li>
								<li><?php _e('Choose a category of the app form <b>Category</b> list.', 'ihc');?></li>
								<li><?php _e('Click on \'+\' from <b>PRODUCTS</b> and set up <b>Facebook Login</b> product. Choose Web platform and set your <b>Site URL</b> with '. site_url() . '.', 'ihc');?></li>
								<li><?php _e('In Facebook Login product from the left side of the menu click on <b>Settings</b> and make sure that <b>Client OAuth Login</b> and <b>Web OAuth Login</b> are \'Yes\'.', 'ihc');?></li>
								<li><?php _e('In <b>Valid OAuth Redirect URIs</b> put the <b>' . $callbackURL . '</b> url.', 'ihc');?></li>
								<li><?php _e('In top of the page your app is in development mode. Switch to Live Mode.', 'ihc');?></li>
								<li><?php _e('In Facebook app go to  Settings > Basic and copy \'App ID\' and \'App Secret\' and paste it to \'Facebook Settings\' from your website.', 'ihc');?></li>
								<li><?php _e('In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked <b>ihc_social_media</b> on register page.', 'ihc');?></li>
								<li><?php _e('Go to UMP Dashboard -> Showcases -> Login Form page. Activate the <b>Show Social Media Login Buttons</b> option.', 'ihc');?></li>

								</ul>

							</div>
							<div class="iump-form-line">
								<p><?php _e("<b>Notice</b>:", "ihc");?></p>
								<p><?php _e("UMP members may synchronized their Facebook account with WP user account from the registration process.", "ihc");?></p>
								<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
				</form>
				<?php
				break;

			case 'tw':
				if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
						ihc_save_update_metas('tw');
				}

				$meta_arr = ihc_return_meta_arr('tw');
				?>
								<div class="iump-page-title">Ultimate Membership Pro -
									<span class="second-text">
										<?php _e('Social Media Login', 'ihc');?>
									</span>
								</div>
								<form action="" method="post">

									<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

									<div class="ihc-stuffbox">
										<h3><?php _e('Twitter Activation:', 'ihc');?></h3>
										<div class="inside">
											<div class="iump-form-line">
												<h4><?php _e("Once everything is set up, activate Twitter login to use it.", "ihc");?></h4>
												<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
												<?php $checked = ($meta_arr['ihc_tw_status']) ? 'checked' : '';?>
												<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_tw_status');" <?php echo $checked;?> />
												<div class="switch" style="display:inline-block;"></div>
											</label>
											<input type="hidden" value="<?php echo $meta_arr['ihc_tw_status'];?>" name="ihc_tw_status" id="ihc_tw_status" />
											</div>
											<div class="ihc-wrapp-submit-bttn iump-submit-form">
												<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
											</div>
										</div>
									</div>
									<div class="ihc-stuffbox">
										<h3><?php _e('Twitter Settings:', 'ihc');?></h3>
										<div class="inside">
											<div class="iump-form-line">
												<label class="iump-labels"><?php _e('API key:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tw_app_key'];?>" name="ihc_tw_app_key" style="width: 300px;" />
											</div>
											<div class="iump-form-line">
												<label class="iump-labels"><?php _e('API secret key:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tw_app_secret'];?>" name="ihc_tw_app_secret" style="width: 300px;" />
											</div>
											<div style="font-size: 11px; color: #333; padding-left: 10px;">
												<div style="font-size: 14px;"><h4><?php _e("How to create a Twitter App")?></h4></div>
												<ul class="ihc-info-list">
												<li><?php _e("Go to ", "ihc");?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a></li>
												<li><?php _e('Create an app.', 'ihc');?></li>
												<li><?php _e('Check <b>Enable Sign in with Twitter</b>.', 'ihc');?></li>
												<li><?php _e('At "Callback URL" you must add ', 'ihc'); echo '<b>'.$callbackURL.'</b>';?></li>
												<li><?php _e('Go back to your website and create 2 pages with Privacy Policy and Terms of Service. Put their URL\'s in <b>Terms of Service URL</b> and <b>Privacy policy URL</b> in your app details.', 'ihc');?></li>
												<li><?php _e('After app was created, go to <b>Keys and tokens </b> tab and copy API keys from Consumer API keys.', 'ihc');?></li>
												<li><?php _e('In Permissions tab check \'Read-only\' in <b>Access permission</b> and  check \'Request email address from users\' in <b>Additional permissions</b>.', 'ihc');?></li>
												<li><?php _e('In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked <b>ihc_social_media</b> on register page.', 'ihc');?></li>
												<li><?php _e('Go to UMP Dashboard -> Showcases -> Login Form page. Activate the <b>Show Social Media Login Buttons</b> option.', 'ihc');?></li>
												</ul>
											</div>
											<div class="iump-form-line">
												<p><?php _e("<b>Notice</b>:", "ihc");?></p>
												<p><?php _e("UMP members may synchronized their Twitter account with WP user account from the registration process.", "ihc");?></p>
												<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
											</div>
											<div class="ihc-wrapp-submit-bttn iump-submit-form">
												<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
											</div>
										</div>
									</div>
								</form>
								<?php
				break;

			case 'in':
				if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
						ihc_save_update_metas('in');
				}

				$meta_arr = ihc_return_meta_arr('in');
				?>
							<div class="iump-page-title">Ultimate Membership Pro -
								<span class="second-text">
									<?php _e('Social Media Login', 'ihc');?>
								</span>
							</div>
							<form action="" method="post">

								<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

								<div class="ihc-stuffbox">
									<h3><?php _e('LinkedIn Activation:', 'ihc');?></h3>
									<div class="inside">
										<div class="iump-form-line">
											<h4><?php _e("Once everything is set up, activate LinkedIn login to use it.", "ihc");?></h4>
											<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
												<?php $checked = ($meta_arr['ihc_in_status']) ? 'checked' : '';?>
												<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_in_status');" <?php echo $checked;?> />
												<div class="switch" style="display:inline-block;"></div>
											</label>
											<input type="hidden" value="<?php echo $meta_arr['ihc_in_status'];?>" name="ihc_in_status" id="ihc_in_status" />
										</div>
										<div class="ihc-wrapp-submit-bttn iump-submit-form">
											<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
										</div>
									</div>
								</div>
								<div class="ihc-stuffbox">
									<h3><?php _e('LinkedIn Settings:', 'ihc');?></h3>
									<div class="inside">
										<div class="iump-form-line">
											<label class="iump-labels"><?php _e('Client ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_in_app_key'];?>" name="ihc_in_app_key" style="width: 300px;" />
										</div>
										<div class="iump-form-line">
											<label class="iump-labels"><?php _e('Client Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_in_app_secret'];?>" name="ihc_in_app_secret" style="width: 300px;" />
										</div>

										<div style="font-size: 11px; color: #333; padding-left: 10px;">
											<div style="font-size: 14px;"><h4><?php _e("How to create a LinkedIn App")?></h4></div>
											<ul class="ihc-info-list">
											<li><?php _e("Go to ", "ihc");?><a href="https://www.linkedin.com/secure/developer" target="_blank">https://www.linkedin.com/secure/developer</a></li>
											<li><?php _e('Click "Create app".', 'ihc');?></li>
											<li><?php _e('In \'LinkedIn Page*\' you have to add an existent LinkedIn company name or create a new company page. Complete the field with company name.', 'ihc');?></li>
                      <li><?php _e('Once the app has been created in \'Settings\' tab you must verify the company. Clik on <b>Verify</b>, and \'Generate URL\'. Open the URL in a browser and click on \'Verify\'.', 'ihc');?></li>
											<li><?php _e( 'In \'OAuth 2.0 settings\' add <b>' . $callbackURL . '</b> redirect URL.' , 'ihc' );?></li>
											<li><?php _e('In \'Products\' select <b>Sign In with LinkedIn</b> product.', 'ihc');?></li>
											<li><?php _e('In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked ihc_social_media on register page.', 'ihc');?></li>
											<li><?php _e('Go to UMP Dashboard -> Showcases -> Login Form page. Activate the Show Social Media Login Buttons option.', 'ihc');?></li>
											</ul>
										</div>
										<div class="iump-form-line">
											<p><?php _e("<b>Notice</b>:", "ihc");?></p>
											<p><?php _e("UMP members may synchronized their LinkedIn accounts with WP user account from the registration process.", "ihc");?></p>
											<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
										</div>

										<div class="ihc-wrapp-submit-bttn iump-submit-form">
											<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
										</div>
									</div>
								</div>
							</form>
						<?php
				break;

			case 'tbr':
					if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
							ihc_save_update_metas('tbr');
					}

					$meta_arr = ihc_return_meta_arr('tbr');
					?>
					<div class="iump-page-title">Ultimate Membership Pro -
						<span class="second-text">
							<?php _e('Social Media Login', 'ihc');?>
						</span>
					</div>
					<form action="" method="post">

						<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

						<div class="ihc-stuffbox">
							<h3><?php _e('Tumblr Activation:', 'ihc');?></h3>
							<div class="inside">
								<div class="iump-form-line">
									<h4><?php _e("Once everything is set up, activate Tumblr login to use it.", "ihc");?></h4>
									<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
										<?php $checked = ($meta_arr['ihc_tbr_status']) ? 'checked' : '';?>
										<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_tbr_status');" <?php echo $checked;?> />
										<div class="switch" style="display:inline-block;"></div>
									</label>
									<input type="hidden" value="<?php echo $meta_arr['ihc_tbr_status'];?>" name="ihc_tbr_status" id="ihc_tbr_status" />
								</div>
								<div class="ihc-wrapp-submit-bttn iump-submit-form">
									<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
								</div>
							</div>
						</div>
						<div class="ihc-stuffbox">
							<h3><?php _e('Tumblr Settings:', 'ihc');?></h3>
							<div class="inside">
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('OAuth consumer key:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tbr_app_key'];?>" name="ihc_tbr_app_key" style="width: 300px;" />
								</div>
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('OAuth consumer secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tbr_app_secret'];?>" name="ihc_tbr_app_secret" style="width: 300px;" />
								</div>

								<div style="font-size: 11px; color: #333; padding-left: 10px;">
									<div style="font-size: 14px;"><h4><?php _e("How to create a Tumblr App")?></h4></div>
									<ul class="ihc-info-list">
									<li><?php _e("Go to ", "ihc");?><a href="http://www.tumblr.com/oauth/apps" target="_blank">http://www.tumblr.com/oauth/apps</a></li>
									<li><?php _e('Register a new application.', 'ihc');?>
									<li><?php _e("Fill out the required fields and submit.", 'ihc');?></li>
									<li><?php _e('Set the "Default callback URL:" as: ', 'ihc'); echo '<b>' . $callbackURL. '</b>';?></li>
									<li><?php _e('After submitting you will find "OAuth consumer key" and "OAuth consumer secret" in the right side of the screen.', 'ihc');?></li>
									<li><?php _e('In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked ihc_social_media on register page.', 'ihc');?></li>
									<li><?php _e('Go to UMP Dashboard -> Showcases -> Login Form page. Activate the Show Social Media Login Buttons option.', 'ihc');?></li>
									</ul>
								</div>
								<div class="iump-form-line">
									<p><?php _e("<b>Notice</b>:", "ihc");?></p>
									<p><?php _e("UMP members may synchronized their Tumblr accounts with WP user account from the registration process.", "ihc");?></p>
									<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
								</div>
								<div class="ihc-wrapp-submit-bttn iump-submit-form">
									<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
								</div>
							</div>
						</div>
					</form>
					<?php
				break;
			case 'ig':
				if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
						ihc_save_update_metas('ig');
				}

				$meta_arr = ihc_return_meta_arr('ig');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">

					<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

					<div class="ihc-stuffbox">
						<h3><?php _e('Instagram Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Instagram login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
									<?php $checked = ($meta_arr['ihc_ig_status']) ? 'checked' : '';?>
									<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_ig_status');" <?php echo $checked;?> />
									<div class="switch" style="display:inline-block;"></div>
								</label>
								<input type="hidden" value="<?php echo $meta_arr['ihc_ig_status'];?>" name="ihc_ig_status" id="ihc_ig_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Instagram Settings:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Client ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_ig_app_id'];?>" name="ihc_ig_app_id" style="width: 300px;" />
							</div>
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Client Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_ig_app_secret'];?>" name="ihc_ig_app_secret" style="width: 300px;" />
							</div>
							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a Instagram App")?></h4></div>
								<ul class="ihc-info-list">
								<li><?php _e("Go to ", "ihc");?><a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a></li>
								<li><?php _e('Create a new App.', 'ihc');?></li>
								<li><?php _e('In Dashboard click on Settings > Basic and fill \'App Domains\' with your site domain (mywebsite.com,  www.mywebsite.com).', 'ihc')?></li>
								<li><?php _e('Go back to your website and create 2 pages with Privacy Policy and Terms of Service. Put their URL\'s in <b>Privacy Policy URL</b> and <b>Terms of Service URL</b> in your Facebook app.', 'ihc');?></li>
								<li><?php _e('Choose a category of the app from <b>Category</b> list.', 'ihc')?></li>
								<li><?php _e('Click on \'+ Add Platform\', choose <b>Website</b> and add https://dev.wpindeed.com/.', 'ihc')?></li>
								<li><?php _e('Click on \'+\' from <b>PRODUCTS</b> and set up an <b>Instagram Basic Display</b> product. Click on \'Create New App\', name the app and create it.', 'ihc')?></li>
								<li><?php _e('Go back to the left side of the dashboard and In \'Instagram Basic Display\' > Basic Display you will find \'Instagram App ID\' and \'Instagram App Secret\'.', 'ihc')?></li>
								<li><?php _e('In \'Client OAuth Settings\' put the <b>' . IHC_URL . 'public/social_handler.php</b>', 'ihc');?> </li>
								<li><?php _e(' In \'Deauthorize\' and \'Data Deletion Requests\' put the ', 'ihc'); echo $callbackURL;?></li>
								<li><?php _e('Add to Submission <b>instagram_graph_user_profile</b> and <b>instagram_graph_user_media</b> from \'App Review for Instagram Basic Display\'.', 'ihc');?></li>

								<li><?php _e('In order to test your app go to <b>Roles</b> and in <b>Instagram Testers</b> add your instagram username.', 'ihc');?></li>
								<li><?php _e('Log in in Instagram, navigate to (Profile Icon) > Edit Profile > <b>Apps and Websites</b> > Tester Invites and accept the invitation.', 'ihc');?></li>
								<li><?php _e('Your Instagram account is now eligible to be accessed by your Facebook app while it is in <b>Development Mode</b>.', 'ihc');?></li>
								<li><?php _e('To get the full access of your app go to Dashboard click on settings > Basic and verify your Business on Facebook.', 'ihc');?></li>
								<li><?php _e('In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked <b>ihc_social_media</b> on register page.', 'ihc')?></li>
								<li><?php _e('Go to UMP Dashboard -> Showcases -> Login Form page. Activate the <b>Show Social Media Login Buttons</b> option.', 'ihc')?></li>
								</ul>
							</div>
							<div class="iump-form-line">
								<p><?php _e("<b>Notice</b>:", "ihc");?></p>
								<p><?php _e("UMP members may synchronized their Instagram accounts with WP user account from the registration process.", "ihc");?></p>
								<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
				</form>
					<?php
				break;
			case 'vk':
				if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
						ihc_save_update_metas('vk');
				}

				$meta_arr = ihc_return_meta_arr('vk');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">

					<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

					<div class="ihc-stuffbox">
						<h3><?php _e('Vkontakte Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Vkontakte login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
									<?php $checked = ($meta_arr['ihc_vk_status']) ? 'checked' : '';?>
									<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_vk_status');" <?php echo $checked;?> />
									<div class="switch" style="display:inline-block;"></div>
								</label>
								<input type="hidden" value="<?php echo $meta_arr['ihc_vk_status'];?>" name="ihc_vk_status" id="ihc_vk_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Vkontakte Settings:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_vk_app_id'];?>" name="ihc_vk_app_id" style="width: 300px;" />
							</div>
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_vk_app_secret'];?>" name="ihc_vk_app_secret" style="width: 300px;" />
							</div>

							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a VK App")?></h4></div>
								<ul class="ihc-info-list">
								<li><?php _e("Go to ", "ihc");?><a href="http://vk.com/developers.php" target="_blank">http://vk.com/developers.php</a></li>
								<li><?php _e("In top of the page click on <b>My Apps</b> and <b>Create app</b>.", 'ihc')?></li>
								<li><?php _e('In \'Platform\' section you must select <b>Website</b>.', 'ihc');?></li>
								<li><?php _e('Connect website.', 'ihc');?></li>
								<li><?php _e('In <b>Contact info</b> section add <b>Terms and Conditions</b> and <b>Privacy Policy</b>pages.', 'ihc');?></li>
								<li><?php _e(' Click on Settings menu tab and make sure that <b>App status</b> is \'Application on and visible to all\'.', 'ihc');?></li>
								<li><?php _e('In Authorized redirect URI add ', 'ihc'); echo '<b>'.$callbackURL.'</b>';?></li>
								<li><?php _e('In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked <b>ihc_social_media</b> on register page.', 'ihc')?></li>
								<li><?php _e('Go to UMP Dashboard -> Showcases -> Login Form page. Activate the <b>Show Social Media Login Buttons</b> option.', 'ihc')?></li>
								</ul>
							</div>
							<div class="iump-form-line">
								<p><?php _e("<b>Notice</b>:", "ihc");?></p>
								<p><?php _e("UMP members may synchronized their Vkontakte accounts with WP user account from the registration process.", "ihc");?></p>
								<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
				</form>
			<?php
			break;

			case 'goo':
				if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
						ihc_save_update_metas('goo');
				}

				$meta_arr = ihc_return_meta_arr('goo');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">

					<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

					<div class="ihc-stuffbox">
						<h3><?php _e(' Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Google login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
									<?php $checked = ($meta_arr['ihc_goo_status']) ? 'checked' : '';?>
									<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_goo_status');" <?php echo $checked;?> />
									<div class="switch" style="display:inline-block;"></div>
								</label>
								<input type="hidden" value="<?php echo $meta_arr['ihc_goo_status'];?>" name="ihc_goo_status" id="ihc_goo_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Google Settings:', 'ihc');?></h3>
							<div class="inside">
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('Application ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_goo_app_id'];?>" name="ihc_goo_app_id" style="width: 300px;" />
								</div>
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_goo_app_secret'];?>" name="ihc_goo_app_secret" style="width: 300px;" />
								</div>

							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a Google App")?></h4></div>
								<ul class="ihc-info-list">
								<li><?php _e("Go to ", "ihc");?><a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a></li>
								<li><?php _e("Create new project.", 'ihc')?></li>
								<li><?php _e('Click on \'OAuth consent screen\'.', 'ihc');?></li>
								<li><?php _e('Choose \'External\' in User Type section.', 'ihc');?></li>
								<li><?php _e('Fill all the reqired fields.', 'ihc');?></li>
								<li><?php _e('In <b>Authorized domains</b> you may add your website domain (mywebsite.com).', 'ihc');?></li>
								<li><?php _e('Return to Credentials from left sidebar menu, and create an OAuth client ID in <b> CREATE CREDENTIALS</b>.', 'ihc');?></li>
								<li><?php _e('In \'Create OAuth client ID\' select Web application. Add callback URL ' . '<b>' . $callbackURL .'</b>' . ' in  <b>Authorized redirect URIs</b> ', 'ihc'); ?></li>
								<li><?php _e('After submitting a popup will appear with \'Your Client ID\' and \'Your Client Secret\'.', 'ihc');?></li>
								<li><?php _e("In 'Domain verification' add a domain to configure webhook notifications.", 'ihc')?></li>
								<li><?php _e("In order to activate social login field, go to UMP Dashboard > SHOWCASES > Register Form > Custom Fields page. Make sure that you have checked <b>ihc_social_media</b> on register page.", 'ihc')?></li>
								<li><?php _e("Go to UMP Dashboard -> Showcases -> Login Form page. Activate the <b>Show Social Media Login Buttons</b> option.", 'ihc')?></li>
								</ul>
							</div>
							<div class="iump-form-line">
								<p><?php _e("<b>Notice</b>:", "ihc");?></p>
								<p><?php _e("UMP members may synchronized their Google accounts with WP user account from the registration process.", "ihc");?></p>
								<p><?php _e("Even after the register step, a user can sync multiple social accounts by going to their profile page, under the <b>Social Plus</b> tab.", "ihc");?></p>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
							</div>
					</div>
				</form>
			<?php
		break;
		}
	}
} else {
	//===================== DESIGN
	if ( isset($_POST['ihc_save'] ) && !empty($_POST['ihc_admin_social_login_nonce']) && wp_verify_nonce( $_POST['ihc_admin_social_login_nonce'], 'ihc_admin_social_login_nonce' ) ){
			ihc_save_update_metas('social_media');//save update metas
	}

	$meta_arr = ihc_return_meta_arr('social_media');//getting metas
	?>
	<div class="iump-page-title">Ultimate Membership Pro -
		<span class="second-text">
			<?php _e('Social Media Login', 'ihc');?>
		</span>
	</div>
		<form action="" method="post">

			<input type="hidden" name="ihc_admin_social_login_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_social_login_nonce' );?>" />

			<div class="ihc-stuffbox">
				<h3><?php _e("Settings", "ihc");?></h3>
				<div class="inside">
					<div class="iump-form-line">
						<label class="iump-labels"><?php _e("Template", 'ihc');?></label>
							<select name="ihc_sm_template"><?php
								$templates = array("ihc-sm-template-1" => "Awesome Template One","ihc-sm-template-2" => "Split Box Template","ihc-sm-template-3" => "Shutter Color Template","ihc-sm-template-4" => "Margarita Template","ihc-sm-template-5" => "Picaso Template");
								foreach ($templates as $k=>$v){
									$selected = ($meta_arr['ihc_sm_template']==$k) ? "selected" : '';
									?>
										<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
									<?php
								}
							?></select>
					</div>
					<div class="iump-form-line">
						<label class="iump-labels"><?php _e("Show Label", 'ihc');?></label>
						<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = (!empty($meta_arr['ihc_sm_show_label'])) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_sm_show_label');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
						</label>
						<input type="hidden" value="<?php echo $meta_arr['ihc_sm_show_label'];?>" name="ihc_sm_show_label" id="ihc_sm_show_label" />
					</div>

					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<div class="ihc-stuffbox">
				<h3><?php _e("Top Content", 'ihc');?></h3>
				<div class="inside">
					<div>
						<?php
							$settings = array(
												'media_buttons' => true,
												'textarea_name'=>'ihc_sm_top_content',
												'textarea_rows' => 5,
												'tinymce' => true,
												'quicktags' => true,
												'teeny' => true,
											);
							wp_editor(ihc_correct_text($meta_arr['ihc_sm_top_content']), 'tag-description', $settings);
						?>
					</div>
					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<div class="ihc-stuffbox">
				<h3><?php _e("Bottom Content", 'ihc');?></h3>
				<div class="inside">
					<div>
						<?php
							$settings = array(
												'media_buttons' => true,
												'textarea_name'=>'ihc_sm_bottom_content',
												'textarea_rows' => 5,
												'tinymce' => true,
												'quicktags' => true,
												'teeny' => true,
											);
							wp_editor(ihc_correct_text($meta_arr['ihc_sm_bottom_content']), 'tag-description', $settings);
						?>
					</div>
					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<div class="ihc-stuffbox">
				<h3><?php _e("Custom CSS", 'ihc');?></h3>
				<div class="inside">
					<div>
						<textarea name="ihc_sm_custom_css" class="ihc-dashboard-textarea-full"><?php echo $meta_arr['ihc_sm_custom_css'];?></textarea>
					</div>
					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
		</form>
	<?php
}
