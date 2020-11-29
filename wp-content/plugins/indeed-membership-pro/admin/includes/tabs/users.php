<div class="ihc-subtab-menu">
	<?php ?>
	<a class="ihc-subtab-menu-item  <?php echo ( @$_REQUEST['ihc-new-user']  == 'true') ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab=users&ihc-new-user=true';?>"><?php _e('Add New Member', 'ihc');?></a>
	<a class="ihc-subtab-menu-item  <?php echo ( !isset($_REQUEST['ihc-new-user'])) ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab='.$tab;?>"><?php _e('Manage Members', 'ihc');?></a>

	<div class="ihc-clear"></div>
</div>
<?php
wp_enqueue_script('ihcAdminSendEmail', IHC_URL . 'admin/assets/js/ihcAdminSendEmail.js', array(), null );
wp_enqueue_script( 'ihcSearchUsers', IHC_URL . 'admin/assets/js/search_users.js', array(), null );

echo ihc_inside_dashboard_error_license();
$is_uap_active = ihc_is_uap_active();

//
if (isset($_POST['delete_users']) && !empty( $_POST['ihc_du'] ) && wp_verify_nonce( $_POST['ihc_du'], 'ihc_delete_users' ) ){
	ihc_delete_users(0, $_POST['delete_users']);
}

$form = '';
include_once IHC_PATH . 'classes/UserAddEdit.class.php';
$obj = new UserAddEdit();
if (isset($_REQUEST['Update'])){
	//update
	$args = array(
			'type' => 'edit',
			'tos' => false,
			'captcha' => false,
			'action' => $url . '&tab=users',
			'is_public' => false,
			'user_id' => $_REQUEST['user_id'],
	);
	$obj->setVariable($args);//setting the object variables
	$obj->save_update_user();

} else if (isset($_REQUEST['Submit'])){
	//create
	$args = array(
			'user_id' => false,
			'type' => 'create',
			'tos' => false,
			'captcha' => false,
			'action' => $url . '&tab=users',
			'is_public' => false,
	);
	$obj->setVariable($args);//setting the object variables
	$obj->save_update_user();
}

$obj_form = new UserAddEdit;
if (isset($_REQUEST['ihc-edit-user'])){
	///EDIT USER FORM
	$args = array(
			'user_id' => $_REQUEST['ihc-edit-user'],
			'type' => 'edit',
			'tos' => false,
			'captcha' => false,
			'action' => $url . '&tab=users',
			'is_public' => false,
	);
	$obj_form->setVariable($args);//setting the object variables
	$form = $obj_form->form();
} else {
	/// CREATE USER FORM
	$args = array(
			'user_id' => false,
			'type' => 'create',
			'tos' => false,
			'captcha' => false,
			'action' => $url . '&tab=users',
			'is_public' => false,
	);
	$obj_form->setVariable($args);//setting the object variables
	$form = $obj_form->form();
}

global $ihc_error_register;
if (!empty($ihc_error_register) && count($ihc_error_register)>0){
	echo '<div class="ihc-wrapp-the-errors">';
	foreach ($ihc_error_register as $key=>$err){
		echo __('Field ', 'ihc') . $key . ': ' . $err;
	}
	echo '</div>';
}


//set default pages message
echo ihc_check_default_pages_set();
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

	if (isset($_REQUEST['ihc-edit-user']) || isset($_REQUEST['ihc-new-user'])){
		//add edit user
		if (isset($_REQUEST['ihc-edit-user'])){
			?>
			<script>
				jQuery(document).ready(function() {
				    jQuery('.start_input_text').datepicker({
				        dateFormat : 'yy-mm-dd',
				        onSelect: function(datetext){
				            var d = new Date();
				            datetext = datetext+" "+d.getHours()+":"+ihcAddZero(d.getMinutes())+":"+ihcAddZero(d.getSeconds());
				            jQuery(this).val(datetext);
				        }
				    });
						jQuery('.expire_input_text').datepicker({
								dateFormat : 'yy-mm-dd',
								onSelect: function(datetext){
										if ( datetext == '' || datetext == null ){
											jQuery( '#' + jQuery(this).parent().parent().attr('id') + ' .ihc-level-status' ).html( '<?php _e('Hold');?>').attr( 'class', '' ).attr( 'class', 'ihc-level-status ihc-level-status-Expired');
										}
										var d = new Date();
										datetext = datetext+" "+d.getHours()+":"+ihcAddZero(d.getMinutes())+":"+ihcAddZero(d.getSeconds());
										jQuery(this).val(datetext);
										var currentTimestamp = ( new Date().getTime()/1000 );
										var selectedTimestamp = (new Date(datetext).getTime() / 1000 );
										if ( currentTimestamp > selectedTimestamp ){
												jQuery( '#' + jQuery(this).parent().parent().attr('id') + ' .ihc-level-status' ).html( '<?php _e( 'Expired', 'ihc' );?>').attr( 'class', '' ).attr( 'class', 'ihc-level-status ihc-level-status-Expired');
										} else {
												jQuery( '#' + jQuery(this).parent().parent().attr('id') + ' .ihc-level-status' ).html( '<?php _e( 'Active', 'ihc');?>' ).attr( 'class', '' ).attr( 'class', 'ihc-level-status ihc-level-status-Active');
										}

								}
						});
				});
			</script>
			<?php
		}
		?>
			<div class="ihc-stuffbox" style="margin-top: 20px;">
				<h3><?php _e('Add/Update Membership Members', 'ihc');?></h3>
				<div class="inside">
                	<div class="ihc-admin-edit-user">
                     <div class="ihc-admin-user-form-wrapper">
                   			 <h2><?php _e('Member Profile details', 'ihc');?></h2>
					 		<p><?php _e('Manage what fields are available for Admin setup from "Showcases->Register Form->Custom Fields" section ', 'ihc');?></p>
                    </div>
						<?php echo $form;?>
					</div>
                </div>
			</div>
		<?php
	} else {
$directLogin = get_option( 'ihc_direct_login_enabled' );
$individual_page = get_option( 'ihc_individual_page_enabled' );
?>
<div class="iump-wrapper">
	<div id="col-right" style="vertical-align:top; width: 100%;">
		<div class="iump-page-title">Ultimate Membership Pro -
			<span class="second-text">
				<?php _e('Membership Members', 'ihc');?>
			</span>
		</div>
		<a href="<?php echo $url.'&tab=users&ihc-new-user=true';?>" class="indeed-add-new-like-wp">
			<i class="fa-ihc fa-add-ihc"></i><?php _e('Add New Member', 'ihc');?>
		</a>

		<div class="ihc-special-buttons-users">
			<div class="ihc-special-button" onclick="ihcShowHide('.ihc-filters-wrapper');"><i class="fa-ihc fa-export-csv"></i>Apply Filters</div>
			<div class="ihc-special-button" style="background-color:#38cbcb;" id="ihc_make_user_csv_file" data-get_variables='<?php echo json_encode( $_GET );?>' onClick="ihcMakeUserCsv();"><i class="fa-ihc fa-export-csv"></i>Export CSV</div>
			<div class="ihc-hidden-download-link" style="display: none;float: right; padding: 20px 20px 0px 0px;"><a href="" target="_blank"><?php _e("Click on this if download doesn't start automatically in 20 seconds!");?></a></div>
			<div class="ihc-clear"></div>
		</div>


		<?php
		$hidded = 'style="display:none;"';
		$possibles = array(
				'search_user',
				'levels',
				'roles',
				'order',
				'levelStatus',
				'approvelRequest',
				'emailVerification',
				'advancedOrder',
		);
		foreach ( $possibles as $possible ){
				if ( isset( $_GET[$possible] ) ){
						$hidded ='';
				}
		}
		?>
		<div class="ihc-filters-wrapper" <?php echo $hidded; ?>>
			<form method="get" action="">
				<input type="hidden" name="page" value="ihc_manage" />
				<input type="hidden" name="tab" value="users" />
				<div class="ihc-section-wrapper">
                 <div class="ihc-filter-section-wrapper ihc-filter-search">
                 	<div class="row-fluid">
					<div class="span10">
						<div class="iump-form-line iump-no-border">
							<input name="search_user" type="text" value="<?php echo (isset($_GET['search_user']) ? $_GET['search_user'] : '') ?>" placeholder="<?php _e('Search by Name or Username, Email', 'ihc');?>..."/>
						</div>
					</div>
					<div class="span2" style="">
						<input type="submit" value="<?php _e( 'Search Members', 'ihc' );?>" name="search" class="button button-primary button-large" id="ihc_search_user_base_field" data-base_link="<?php echo admin_url( 'admin.php?page=ihc_manage&tab=users' );?>" />
					</div>
                    </div>
				</div>
                <div class="ihc-filter-section-wrapper">
                <div class="row-fluid">
                	<div class="col-xs-6">
                    	<div class="span12">
					<div class="iump-form-line iump-no-border">
						<h3><?php _e( 'Filter by Levels', 'ihc' );?></h3>
                        <div class="ihc-search-user-select-filter-bttn js-ihc-select-all-levels ihc-search-user-select-all"><?php _e( 'Select all Levels', 'ihc');?></div>
						<div class="ihc-search-user-select-filter-bttn js-ihc-deselect-all-levels  ihc-search-user-select-all"><?php _e( 'Deselect all Levels', 'ihc');?></div>
                        <div></div>
						<?php $levels_arr = get_option('ihc_levels');?>
						<?php if ( $levels_arr ):?>
								<?php
										$getValues = isset( $_GET['levels'] ) ? $_GET['levels'] : '';
										if ( stripos( $getValues, ',' ) !== false ) {
												$getValues = explode( ',', $getValues);
										} else {
												$getValues = array( $getValues );
										}
								?>
								<?php foreach ( $levels_arr as $id => $levelData ): ?>
										<?php $enabled = in_array( $id, $getValues ) ? 1 : 0;?>
										<div class="ihc-search-user-select-filter-bttn js-ihc-search-select <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="levels" data-value="<?php echo $id;?>" data-enabled="<?php echo $enabled;?>" ><?php echo $levelData['label'];?></div>
								<?php endforeach;?>
						<?php endif;?>

					</div>
				</div>
                		<div class="span12">
					<div class="iump-form-line iump-no-border">
						<h3><?php _e( 'Filter by Levels status', 'ihc' );?></h3>
						<?php
						$statusArray = array(
																	'active'			  => __( 'Active', 'ihc' ),
																	'expired'			  => __( 'Expired', 'ihc' ),
																	'hold'				  => __( 'On hold', 'ihc' ),
																	'expire_soon'  => __( 'Expire soon', 'ihc' ),
						);
						?>
						<?php if ( $statusArray ):?>
								<?php
										$getValues = isset( $_GET['levelStatus'] ) ? $_GET['levelStatus'] : '';
										if ( stripos( $getValues, ',' ) !== false ) {
												$getValues = explode( ',', $getValues);
										} else {
												$getValues = array( $getValues );
										}
								?>
								<?php foreach ( $statusArray as $key => $label ): ?>
										<?php $enabled = in_array( $key, $getValues ) ? 1 : 0;?>
										<div class="ihc-search-user-select-filter-bttn js-ihc-search-select ihc-filter-level-<?php echo $key; ?> <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="levelStatus" data-value="<?php echo $key;?>" data-enabled="<?php echo $enabled;?>" ><?php echo $label;?></div>
								<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>

                    </div>

                    <div class="col-xs-6">
                    	<div class="span12">
					<div class="iump-form-line iump-no-border ihc-filter-wproles">
						<h3><?php _e( 'WordPress Roles', 'ihc' );?></h3>
							<?php
								$filter_roles = ihc_get_wp_roles_list();
								if ( isset( $filter_roles['pending_user'] ) ){
										unset( $filter_roles['pending_user'] );
								}
							?>
							<?php if ($filter_roles):?>
                            <div class="ihc-search-user-select-filter-bttn js-ihc-select-all-roles ihc-search-user-select-all"><?php _e( 'Select all Roles', 'ihc');?></div>
							<div class="ihc-search-user-select-filter-bttn js-ihc-deselect-all-roles ihc-search-user-select-all"><?php _e( 'Deselect all Roles', 'ihc');?></div>
                            <div></div>
									<?php
											$getValues = isset( $_GET['roles'] ) ? $_GET['roles'] : '';
											if ( stripos( $getValues, ',' ) !== false ) {
													$getValues = explode( ',', $getValues);
											} else {
													$getValues = array( $getValues );
											}
									?>
									<?php foreach ( $filter_roles as $key => $label ): ?>
											<?php $enabled = in_array( $key, $getValues ) ? 1 : 0;?>
											<div class="ihc-search-user-select-filter-bttn js-ihc-search-select <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="roles" data-value="<?php echo $key;?>" data-enabled="<?php echo $enabled;?>" ><?php echo $label;?></div>
									<?php endforeach;?>
							<?php endif;?>

					</div>
				</div>
                <div>
                <h3><?php _e( 'Administrator Requests', 'ihc' );?></h3>

						<?php $enabled = isset( $_GET['approvelRequest'] ) && $_GET['approvelRequest'] ? 1 : 0;?>
						<div class="ihc-search-user-select-filter-bttn js-ihc-search-select <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="approvelRequest" data-value="1" data-enabled="<?php echo $enabled;?>" ><?php _e( 'Approvel request', 'ihc' );?></div>

						<?php $enabled = isset( $_GET['emailVerification'] ) && $_GET['emailVerification'] ? 1 : 0;?>
						<div class="ihc-search-user-select-filter-bttn js-ihc-search-select <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="emailVerification" data-value="1" data-enabled="<?php echo $enabled;?>" ><?php _e( 'Pending E-mail Verification', 'ihc' );?></div>

                </div>
                    </div>


	</div>
    </div>
    <div class="ihc-filter-section-wrapper  ihc-filter-orders">
                <div class="row-fluid">
                <div class="col-xs-8">
				<div class="span12">
					<div class="iump-form-line iump-no-border">
						<h3><?php _e( 'Order', 'ihc' );?></h3>
						<?php
								$possibleOrders = array(
																					'display_name_asc'										=> __( 'Name ASC', 'ihc' ),
																					'display_name_desc'										=> __( 'Name DESC', 'ihc'),
																					'user_login_asc'											=> __( 'Username ASC', 'ihc' ),
																					'user_login_desc'											=> __( 'Username DESC', 'ihc' ),
																					'user_email_asc'											=> __( 'Email ASC', 'ihc' ),
																					'user_email_desc'											=> __( 'Email DESC', 'ihc' ),
																					'ID_asc'															=> __( 'ID ASC', 'ihc' ),
																					'ID_desc'															=> __( 'ID DESC', 'ihc' ),
																					'user_registered_asc'									=> __( 'Registered Time ASC', 'ihc' ),
																					'user_registered_desc'								=> __( 'Registered Time DESC', 'ihc' ),
								);
						?>
						<?php foreach ( $possibleOrders as $key => $label ):?>
								<?php $enabled = isset( $_GET['order'] ) && $_GET['order'] == $key ? 1 : 0;?>
								<div class="ihc-search-user-select-filter-bttn js-ihc-search-order <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="order" data-value="<?php echo $key;?>" data-enabled="<?php echo $enabled;?>" ><?php echo $label;?></div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
            <div class="col-xs-4">
				<div class="span12">
						<?php
								$getValues = isset( $_GET['advancedOrder'] ) ? $_GET['advancedOrder'] : '';
								if ( stripos( $getValues, ',' ) !== false ) {
										$getValues = explode( ',', $getValues);
								} else {
										$getValues = array( $getValues );
								}
						?>
						<h3><?php _e( 'Advanced order', 'ihc' );?></h3>
						<?php $enabled = in_array( 'newSubscription', $getValues ) ? 1 : 0;?>
						<div class="ihc-search-user-select-filter-bttn js-ihc-search-advanced-order <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="advancedOrder" data-value="newSubscription" data-enabled="<?php echo $enabled;?>" ><?php _e( 'New Memberships', 'ihc' );?></div>
						<?php $enabled = in_array( 'recentlyExpired', $getValues ) ? 1 : 0;?>
						<div class="ihc-search-user-select-filter-bttn js-ihc-search-advanced-order <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="advancedOrder" data-value="recentlyExpired" data-enabled="<?php echo $enabled;?>" ><?php _e( 'Recently Expired', 'ihc' );?></div>
						<?php $enabled = in_array( 'goingToExpire', $getValues ) ? 1 : 0;?>
						<div class="ihc-search-user-select-filter-bttn js-ihc-search-advanced-order <?php echo $enabled ? 'ihc-green-bttn' : 'ihc-gray-bttn';?>" data-name="advancedOrder" data-value="goingToExpire" data-enabled="<?php echo $enabled;?>" ><?php _e( 'Going to expire', 'ihc' );?></div>
				</div>
			</div>
            </div>
            </div>
			</div>
			</form>
		</div>
		<form method="post" action="" style="margin-top:20px;" name="ihc-users">
			<?php
				$currency = get_option( 'ihc_currency' );
				$limit = (isset($_GET['ihc_limit'])) ? (int)$_GET['ihc_limit'] : 25;
				$start = 0;
				if(isset($_GET['ihcdu_page'])){
					$pg = (int)$_GET['ihcdu_page'] - 1;
					if ( $pg < 0){
						$pg = 0;
					}
					$start = (int)$pg * $limit;
				}
				$search_query = isset($_GET['search_user']) ? $_GET['search_user'] : '';
				$filter_role = isset($_GET['roles']) ? $_GET['roles'] : '';
				$search_level = isset($_GET['levels']) ? $_GET['levels'] : -1;
				$order = isset($_GET['order']) ? $_GET['order'] : 'user_registered_desc'; // user_registered_desc
				$approveRequest = isset( $_GET['approvelRequest'] ) && $_GET['approvelRequest'] ? true : false;
				$advancedOrder = isset( $_GET['advancedOrder'] ) ? $_GET['advancedOrder'] : '';
				$levelStatus = isset( $_GET['levelStatus'] ) ? $_GET['levelStatus'] : '';
				$emailVerification = isset( $_GET['emailVerification'] ) && $_GET['emailVerification'] ? 1 : 0;

				$searchUsers = new \Indeed\Ihc\Db\SearchUsers();
				$searchUsers->setLimit( $limit )
										->setOffset( $start )
										->setOrder( $order )
										->setLid( $search_level )
										->setSearchWord( $search_query )
										->setRole( $filter_role )
										->setAdvancedOrder( $advancedOrder )
										->setLevelStatus( $levelStatus )
										->setOnlyDoubleEmailVerification( $emailVerification )
										->setApprovelRequest( $approveRequest );
				$total_users = $searchUsers->getCount();
				$users = $searchUsers->getResults();
				$levelDetails = \Ihc_Db::getLevelsDetails();
			?>
			<div>
				<?php
					//SEARCH FILTER BY USER LEVELS
					if ($start==0) $current_page = 1;
					else $current_page = (int)$_GET['ihcdu_page'];

					require_once IHC_PATH . 'classes/Ihc_Pagination.class.php';

					$url = IHC_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					$pagination_object = new Ihc_Pagination(array(
																'base_url' => $url,
																'param_name' => 'ihcdu_page',
																'total_items' => $total_users,
																'items_per_page' => $limit,
																'current_page' => $current_page,
					));
					$pagination = $pagination_object->output();


					/// UAP
					if ($is_uap_active){
						global $indeed_db;
						if (empty($indeed_db) && defined('UAP_PATH')){
							include UAP_PATH . 'classes/Uap_Db.class.php';
							$indeed_db = new Uap_Db;
						}
					}
					/// UAP

					$magic_feat_user_sites = ihc_is_magic_feat_active('user_sites');

					if ($users){
						?>
							<div style="margin: 10px 0px;">
								<div style="display: inline-block;float: left;" >
									<input type="submit" value="<?php _e('Delete', 'ihc');?>" name="delete" onClick="event.preventDefault();ihcFirstConfirmBeforeSubmitForm('<?php _e('Are You Sure You want to delete selected Members?');?>');" class="button button-primary button-large ihc-remove-group-button"/>
								</div>
<?php
$url = IHC_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = remove_query_arg('ihc_limit', $url);
$url = remove_query_arg('ihcdu_page', $url);
?>
								<div style="display: inline-block;float: right;margin-right:10px;">
									<strong><?php _e('Number of Members per Page:', 'ihc');?></strong>
									<select name="ihc_limit" class="js-ihc-search-users-limit" onChange="window.location = '<?php echo $url;?>&ihc_limit='+this.value;">
										<?php
											foreach(array(5,25,50,100,200,500) as $v){
												?>
													<option value="<?php echo $v;?>" <?php if($limit==$v) echo 'selected';?> ><?php echo $v;?></option>
												<?php
											}
										?>
									</select>
								</div>
								<?php //////////////////PAGINATION
											echo $pagination;
									?>
								<div class="clear"></div>
							</div>
							<div class="iump-rsp-table">
						   <table class="wp-list-table widefat fixed tags ihc-admin-tables ihc-admin-tables-users">
							  <thead>
								<tr>
									  <th style="width: 30px;">
									  	<input type="checkbox" onClick="ihcSelectAllCheckboxes( this, '.ihc-delete-user' );" />
									  </th>
									  <th class="manage-column" style="width:8%;">
											<?php _e('Full Name', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:5%;">
											<?php _e('Username', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:8%;">
											<?php _e('Email Address', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:250px;">
											<?php _e('Membership Plans', 'ihc');?>
									  </th>
										<th  style="width:80px;"><?php _e( 'Total Spend', 'ihc' );?></th>
										<?php do_action( 'ump_action_admin_list_user_column_name_after_total_spend' );?>
									  <?php if (!empty($magic_feat_user_sites)):?>
									  <th class="manage-column">
									  		<?php _e('Sites', 'ihc');?>
									  </th>
									  <?php endif;?>
									  <th class="manage-column" style="width:100px;">
											<?php _e('WP Member Role', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:100px;">
											<?php _e('Email Status', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:6%;">
											<?php _e('Sign Up date', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:10%;">
											<?php _e('Details', 'ihc');?>
									  </th>
							    </tr>
							  </thead>
							  <tfoot>
								<tr>
									  <th style="width: 30px;">
									  	<input type="checkbox" onClick="ihcSelectAllCheckboxes( this, '.ihc-delete-user' );" />
									  </th>
									  <th class="manage-column">
											<?php _e('Full Name', 'ihc');?>
									  </th>
									  <th class="manage-column">
											<?php _e('Username', 'ihc');?>
									  </th>
									  <th class="manage-column">
											<?php _e('Email Address', 'ihc');?>
									  </th>
									  <th class="manage-column" style="width:250px;">
											<?php _e('Membership Plans', 'ihc');?>
									  </th>
										<th><?php _e( 'Total Spend', 'ihc' );?></th>
										<?php do_action( 'ump_action_admin_list_user_column_name_after_total_spend' );?>
									  <?php if (!empty($magic_feat_user_sites)):?>
									  <th class="manage-column">
									  		<?php _e('Sites', 'ihc');?>
									  </th>
									  <?php endif;?>
									  <th class="manage-column">
											<?php _e('WP Member Role', 'ihc');?>
									  </th>
									  <th class="manage-column">
											<?php _e('Email Status', 'ihc');?>
									  </th>
									  <th class="manage-column">
											<?php _e('Sign up date', 'ihc');?>
									  </th>
									  <th class="manage-column">
											<?php _e('Details', 'ihc');?>
									  </th>
							    </tr>
							  </tfoot>
							  <?php
							  		$i = 1;
							  		$available_roles = ihc_get_wp_roles_list();

							  		foreach ($users as $user){
											$userIds[] = $user->ID;
							  			$verified_email =  get_user_meta($user->ID, 'ihc_verification_status', TRUE);
											$roles = isset($user->roles) ? array_keys(unserialize($user->roles)) : $user->roles;
							  			?>
			    						   		<tr id="<?php echo "ihc_user_id_" . $user->ID;?>" class="<?php if($i%2==0) echo 'alternate';?>" onMouseOver="ihcDhSelector('#user_tr_<?php echo $user->ID;?>', 1);" onMouseOut="ihcDhSelector('#user_tr_<?php echo $user->ID;?>', 0);">
			    						   			<th>
									  					<input type="checkbox" class="ihc-delete-user" name="delete_users[]" value="<?php echo $user->ID;?>" />
									 				</th>
			    						   			<td>
                                                    <?php
																	$firstName = isset( $user->first_name ) ? $user->first_name : '';
																	$lastName = isset( $user->last_name ) ? $user->last_name : '';
			    						   					if ( !empty( $firstName ) || !empty( $lastName ) ){
			    						   						echo $firstName . ' ' . $lastName;
			    						   					} else {
			    						   						echo $user->user_nicename;
			    						   					}
			    						   				?>

														<?php
															if ($is_uap_active && !empty($indeed_db)){
																$is_affiliate = $indeed_db->is_user_affiliate_by_uid($user->ID);
																if ($is_affiliate){
																	?>
																	<span class="ihc-user-is-affiliate"><?php _e('Affiliate', 'ihc');?></span>
																	<?php
																}
															}
														?>

														<div class="ihc-buttons-rsp" style="visibility:hidden;" id="user_tr_<?php echo $user->ID;?>">
															<a class="iump-btns" href="<?php echo $url.'&tab=users&ihc-edit-user='.$user->ID;?>"><?php _e('Edit', 'ihc');?></a>

															<a class="iump-btns" onClick="ihcDeleteUserPrompot(<?php echo $user->ID;?>);" href="javascript:return false;" style="color: red;"><?php _e('Delete', 'ihc');?></a>
															<?php
																///get role !!!!
																if (isset($roles) && $roles[0]=='pending_user'){
																	?>
																	<span id="approveUserLNK<?php echo $user->ID;?>" onClick="ihcApproveUser(<?php echo $user->ID;?>);">
																	 <span class="iump-btns" style="cursor:pointer; color: #0074a2;"><?php _e('Approve', 'ihc');?></span>
																	</span>
																	<?php
																}
																if ($verified_email==-1){
																	?>
																	<span id="approve_email_<?php echo $user->ID;?>" onClick="ihcApproveEmail(<?php echo $user->ID;?>, '<?php _e("Verified", "ihc");?>');">
																	 <span class="iump-btns" style="cursor:pointer; color: #0074a2;"><?php _e('Approve E-mail', 'ihc');?></span>
																	</span>
																	<?php
																}
															?>
														</div>

			    						   			</td>
			    						   			<td class="ihc-users-list-name">
			    						   				<?php echo $user->user_login;?>
			    						   			</td>
			    						   			<td>
			    						   				<a href="<?php echo 'mailto:' . $user->user_email;?>" target="_blank"><?php echo $user->user_email;?></a>
			    						   			</td>
			    						   			<td style="font-weight:bold;">
			    						   				<?php
															$levels = array();
															if ( $user->levels && stripos( $user->levels, ',' ) !== false ){
																	$levels = explode( ',', $user->levels );
															} else {
																	$levels[] = $user->levels;
															}

															if ( $levels ){
																foreach ( $levels as $levelData ){
																			if ( $levelData == -1 ){
																					continue;
																			}
																			if ( strpos( $levelData, '|' ) !== false ){
																					$levelDataArray = explode( '|', $levelData );
																			} else {
																					$levelDataArray = array();
																			}

																			$lid = isset( $levelDataArray[0] ) ? $levelDataArray[0] : '';
																			$level_data = array(
																						'level_id'		=> $lid,
																						'start_time'	=> isset( $levelDataArray[1] ) ? $levelDataArray[1] : '',
																						'expire_time' => isset( $levelDataArray[2] ) ? $levelDataArray[2] : '',
																						'level_slug'	=> isset( $levelDetails[$lid]['slug'] ) ? $levelDetails[$lid]['slug'] : '',
																						'label'				=> isset( $levelDetails[$lid]['label'] ) ? $levelDetails[$lid]['label'] : '',
																			);

					    						   					$is_expired_class = '';
					    						   					$level_title = "Active";

																			/// is expired
																			if ( !\Ihc_Db::is_user_level_active( $user->ID, $lid ) ){
																					$is_expired_class = 'ihc-expired-level';
																					$level_title = "Hold/Expired";
																			}

																			$level_format = ihc_prepare_level_show_format($level_data);
																	?>
                                                                    <div class="ihc-level-skin-wrapper">
                                                                    	<span class="ihc-level-skin-element ihc-level-skin-box">
                                                                        	<span class="ihc-level-skin-element">
                                                                            	<span class="ihc-level-skin-line"></span>
                                                                                <span class="ihc-level-skin-min <?php echo $level_format['time_class']; ?>"><?php echo $level_format['start_time_format']; ?></span>
                                                                                <span class="ihc-level-skin-max <?php echo $level_format['time_class']; ?>"><?php echo $level_format['expire_time_format']; ?></span>
                                                                            </span>
                                                                            <span class="ihc-level-skin-bar <?php echo $level_format['bar_class'];?>" style="width:<?php echo $level_format['bar_width'];?>%;">

                                                                                <span class="ihc-level-skin-single <?php echo $level_format['tooltip_class'];?>"><?php echo $level_format['tooltip_message'];?></span>
                                                                            </span>
                                                                            <span class="ihc-level-skin-grid">
                                                                            	<?php echo $level_data['label']?>
                                                                            </span>
                                                                            <span class="ihc-level-skin-down-grid"><?php echo $level_format['extra_message'];?></span>
                                                                        </span>
                                                                    </div>


																	<!--div class="level-type-list <?php echo $is_expired_class;?>" title="<?php echo $level_data['level_slug']?>"><?php echo $level_data['label']?></div-->
																	<?php
																}
															}
			    						   				?>
			    						   			</td>
															<td class="ihc-users-list-joindate"><?php
																	echo ihc_format_price_and_currency_with_price_wrapp($currency, 0, " id='ihc_js_total_spent_for_{$user->ID}' ");
															?></td>
															<?php do_action( 'ump_action_admin_list_user_row_after_total_spend', $user->ID );?>
															<?php if (!empty($magic_feat_user_sites)):?>
			    						   				<?php
															$sites = array();
															$temp = array();
															if (!empty($user_levels)){
																foreach ($user_levels as $lid=>$level_data){
																	$temp['blog_id'] = Ihc_Db::get_user_site_for_uid_lid($user->ID, $lid);
																	if (!empty($temp['blog_id'])){
																		$site_details = get_blog_details( $temp['blog_id'] );
																		$temp['link'] = untrailingslashit($site_details->domain . $site_details->path);
																		$temp['blogname'] = $site_details->blogname;
																		if (strpos($temp['link'], 'http')===FALSE){
																			$temp['link'] = 'http://' . $temp['link'];
																		}
																		$temp['extra_class'] = Ihc_Db::is_blog_available($temp['blog_id']) ? 'fa-sites-is-active' : 'fa-sites-is-not-active';
																		$sites[] = $temp;
																	}
																}
															}
			    						   				?>
												  		<td class="manage-column">
												  			<?php if ($sites):?>
												  				<?php foreach ($sites as $site_data):?>
														  			<a href="<?php echo $temp['link'];?>" target="_blank" title="<?php echo $temp['blogname'];?>">
															  			<i class="fa-ihc fa-user_sites-ihc <?php echo $site_data['extra_class'];?>"></i>
														  			</a>
												  				<?php endforeach;?>
												  			<?php endif;?>
												  		</td>
												  	<?php endif;?>
			    						   			<td>
			    						   				<div id="user-<?php echo $user->ID;?>-status">
				    						   				<?php
				    						   					if (isset($roles) && $roles[0]=='pending_user'){
				    						   						 ?>
				    						   						 	<span class="subcr-type-list iump-pending"><?php _e('Pending', 'ihc');?></span>
				    						   						 <?php
				    						   					} else {
				    						   						 ?>
				    						   						 	<span class="subcr-type-list"><?php
				    						   						 		if (isset($roles) && isset($available_roles[$roles[0]])){
				    						   						 			echo $available_roles[$roles[0]];
				    						   						 		} else {
																				echo '-';
				    						   						 		}
				    						   						 	?></span>
				    						   						 <?php
				    						   					}
																		if (count($roles)>1){
																				for ($i=1;$i<count($roles); $i++){
																						?>
																						<span class="subcr-type-list">
																								<?php if (isset($available_roles[$roles[$i]])) echo $available_roles[$roles[$i]];
																											else echo __('Unknown role', 'ihc');
																								?>
																						</span>
																						<?php
																				}
																		}
				    						   				?>
			    						   				</div>
			    						   			</td>
			    						   			<td><?php
			    						   				$div_id = "user_email_" . $user->ID . "_status";
			    						   				$class = 'subcr-type-list';
			    						   				if ($verified_email==1){
			    						   					$label = __('Verified', 'ihc');
			    						   				} else if ($verified_email==-1){
			    						   					$label = __('Unapproved', 'ihc');
			    						   					$class = 'subcr-type-list iump-pending';
			    						   				} else {
			    						   					$label = __('-', 'ihc');
			    						   				}
			    						   				?>
			    						   					<div id="<?php echo $div_id;?>">
			    						   						<span class="<?php echo $class;?>"><?php echo $label;?></span>
			    						   					</div>
			    						   				<?php
			    						   			?></td>
			    						   			<td class="ihc-users-list-joindate">
			    						   				<?php
			    						   					echo ihc_convert_date_to_us_format($user->user_registered);
			    						   				?>
			    						   			</td>
													<td>
														<?php
														$ord_count = ihc_get_user_orders_count($user->ID);
														if(isset($ord_count) && $ord_count > 0): ?>
														<div class="ihc_frw_button"> <a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=orders&uid=') . $user->ID;?>" target="_blank"><?php _e('Orders', 'ihc');?></a></div>
														<?php endif;?>
														<?php unset($ord_count);?>

                                                        <?php if ($directLogin):?>
																<div class="ihc_frw_button ihc_small_blue_button ihc-admin-direct-login-generator ihc-pointer " data-uid="<?php echo $user->ID; ?>"><?php _e('Direct Login', 'ihc');?></div>
														<?php endif;?>

                                                        <div class="ihc_frw_button ihc_small_grey_button ihc-admin-do-send-email-via-ump" data-uid="<?php echo $user->ID; ?>"><?php _e('Direct Email', 'ihc');?></div>

														<?php if (ihc_is_magic_feat_active('user_reports') && Ihc_User_Logs::get_count_logs('user_logs', $user->ID)):?>
															<div class="level-type-list ihc_small_red_button"> <a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=view_user_logs&type=user_logs&uid=') . $user->ID;?>" target="_blank" style="color: #fff;"><?php _e('User Reports', 'ihc');?></a></div>
														<?php endif;?>

                                                        <?php if ($individual_page):?>
																<div class="level-type-list ihc_small_yellow_button"> <a href="<?php echo ihc_return_individual_page_link($user->ID);?>" target="_blank" style="color: #fff;"><?php _e('Individual Page', 'ihc');?></a></div>
														<?php endif;?>

													</td>
			    						   		</tr>
							  			<?php
							  			$i++;
							  		}
							  ?>
						   </table>
						 </div>
						   <div style="margin-top: 10px;">
						   		<input type="submit" value="<?php _e('Delete', 'ihc');?>" name="delete" onClick="event.preventDefault();ihcFirstConfirmBeforeSubmitForm('<?php _e('Are You Sure You want to delete selected Members?');?>');" class="button button-primary button-large ihc-remove-group-button"/>
						   </div>
						<?php
					}else{ ?>
					<div  class="ihc-warning-message"><?php _e('No Members Available.', 'ihc');?></div>
					<?php }
				?>
			</div>
			<input type="hidden" name="ihc_du" value="<?php echo wp_create_nonce( 'ihc_delete_users' );?>" />
		</form>
	</div>
</div>
<div class="clear"></div>
<style>
.sweet-alert {
    background-color: #ffffff;
    width: 800px;
}
</style>
<?php if ( !empty( $userIds ) ):?>
<script>
window.addEventListener( 'load', function(){
	jQuery.ajax({
			type : "post",
			url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
			data : {
								 action			: "ihc_admin_list_users_total_spent_values",
								 users   		: '<?php echo implode(',', $userIds);?>',
						 },
			success: function (data) {
					if ( !data || data == '' ){
							return false;
					}
					var jsonObject = JSON.parse( data );
					Object.keys( jsonObject ).forEach( function (key){
							document.getElementById('ihc_js_total_spent_for_'+key).innerHTML = jsonObject[key];
					});
			}
 });
});
</script>
<?php endif;?>
<?php
}
