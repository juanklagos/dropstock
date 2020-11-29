<?php if (!empty($data['custom_css'])):?>
	<style><?php echo $data['custom_css'];?></style>
<?php endif;?>

<?php wp_enqueue_style( 'ihc-croppic_css', IHC_URL . 'assets/css/croppic.css' );?>
<?php wp_enqueue_script( 'ihc-jquery_mousewheel', IHC_URL . 'assets/js/jquery.mousewheel.min.js', array(), null );?>
<?php wp_enqueue_script( 'ihc-croppic', IHC_URL . 'assets/js/croppic.js', array(), null );?>
<?php wp_enqueue_script( 'ihc-account_page-banner', IHC_URL . 'assets/js/account_page-banner.js', array(), null );?>

<script>
jQuery( document ).ready( function(){
		IhcAccountPageBanner.init({
				triggerId					: 'js_ihc_edit_top_ap_banner',
				saveImageTarget		: '<?php echo IHC_URL . 'public/ajax-upload.php';?>',
				cropImageTarget   : '<?php echo IHC_URL . 'public/ajax-upload.php';?>',
				bannerClass       : 'ihc-user-page-top-ap-background'
		})
})
</script>
<div class="ihc-account-page-wrapp" id="ihc_account_page_wrapp">

	<?php
		$top_style='';
		if (empty($this->settings['ihc_ap_edit_background']) && ($this->settings['ihc_ap_top_template'] == 'ihc-ap-top-theme-2' || $this->settings['ihc_ap_top_template'] == 'ihc-ap-top-theme-3' )){
			$top_style .='style="padding-top:75px;"';
		}
	?>

		<div class="ihc-user-page-top-ap-wrapper <?php echo (!empty($this->settings['ihc_ap_top_template']) ? $this->settings['ihc_ap_top_template'] : '');?>" <?php echo $top_style;?> >

		  	<div class="ihc-left-side">
				<div class="ihc-user-page-details">
					<?php if (!empty($data['avatar'])):?>
						<div class="ihc-user-page-avatar"><img src="<?php echo $data['avatar'];?>" class="ihc-member-photo"/></div>
					<?php endif;?>
				</div>
			</div>

			<div class="ihc-middle-side">
				<div class="ihc-account-page-top-mess">
                <?php if ($this->settings['ihc_ap_top_template'] == 'ihc-ap-top-theme-4' ){ ?>
                	<div class="iump-user-page-name"><?php echo $first_name . ' ' . $last_name;?></div>
                <?php } ?>
                   <div class="ihc-account-page-top-extra-mess">
					<?php if (!empty($data['welcome_message'])):?>
						<?php echo do_shortcode($data['welcome_message']);?>
					<?php endif;?>
                    </div>
				</div>
				<?php if (!empty($data['levels'])):?>
					<div class="ihc-top-levels">
						<?php foreach ($data['levels'] as $lid => $level):?>
							<?php
				    			$time_arr = ihc_get_start_expire_date_for_user_level($this->current_user->ID, $lid);
						    	$is_expired_class = '';
									if ( !isset( $time_arr['expire_time'] ) ){
											$time_arr['expire_time'] = '';
									}
									$time_arr['expire_time'] = apply_filters( 'ump_public_account_page_level_expire_time', $time_arr['expire_time'], $this->current_user->ID, $lid );
									// @description

								if (isset($time_arr['expire_time']) && indeed_get_unixtimestamp_with_timezone()>strtotime( $time_arr['expire_time'] ) ){
						    		$is_expired_class = 'ihc-expired-level';
						    	}
							?>
							<?php if (!empty($data['badges_metas']['ihc_badges_on']) && !empty($level['badge_image_url'])):?>
								<div class="iump-badge-wrapper <?php echo $is_expired_class;?>"><img src="<?php echo $level['badge_image_url'];?>" class="iump-badge" title="<?php echo $level['label'];?>" /></div>
							<?php elseif (!empty($level['label'])):?>
								<div class="ihc-top-level-box <?php echo $is_expired_class;?>"><?php echo $level['label'];?></div>
							<?php endif;?>
						<?php endforeach;?>
					</div>
				<?php endif;?>
				<?php if (!empty($data['sm'])):?>
					<div class="ihc-ap-top-sm">
						<?php echo $data['sm'];?>
					</div>
				<?php endif;?>
			</div>

			<div class="ihc-clear"></div>
				<?php
					if (!empty($this->settings['ihc_ap_edit_background'])):
						$bk_style = '';
						$banner = '';
						if (!empty($this->settings['ihc_ap_top_background_image'])):
								$banner = $this->settings['ihc_ap_top_background_image'];
						endif;
						if (!empty($data ['top_banner'])):
							$banner = $data ['top_banner'];
						endif;
						if (!empty($banner)){
								$bk_style = 'style="background-image:url('.$banner.');"';
						}
			 	?>
            <div class="ihc-background-overlay"></div>
				  	<div class="ihc-user-page-top-ap-background" <?php echo $bk_style;?> data-banner="<?php echo $banner;?>" >

						</div>
                    <div class="ihc-edit-top-ap-banner" id="js_ihc_edit_top_ap_banner"></div>
		  <?php endif;?>

		</div>
		<div class="ihc-user-page-content-wrapper  <?php echo @$this->settings['ihc_ap_theme'];?>">

<?php
