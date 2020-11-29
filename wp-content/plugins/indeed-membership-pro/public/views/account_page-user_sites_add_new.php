<div class="ihc-ap-wrap">
	<?php if (!empty($data['title'])):?>
		<h3><?php echo do_shortcode($data['title']);?></h3>
	<?php endif;?>
	<?php if (!empty($data['content'])):?>
		<p><?php echo do_shortcode($data['content']);?></p>
	<?php endif;?>
	<?php if (!empty($data['error'])):?>
		<div class="ihc-wrapp-the-errors"><?php echo $data['error'];?></div>
	<?php endif;?>
	<?php global $current_site;?>

	<form method="post" action="<?php echo $data['save_link'];?>">
		<input type="hidden" name="ihc_multi_site_add_edit_nonce" value="<?php echo wp_create_nonce( 'ihc_multi_site_add_edit_nonce' );?>" />
		<div class="ihc-form-line-register ihc-form-text">
			<label class="ihc-labels-register ihc-content-bold"><?php _e('Site Address', 'ihc');?></label>
			<?php if ( isset( $current_site->domain ) && isset( $current_site->path ) ):?>
					<?php echo $current_site->domain . $current_site->path;?>
		  <?php endif;?>
			<input type="text" name="domain" value=""/>
		</div>
		<div class="ihc-form-line-register ihc-form-text">
			<label class="ihc-labels-register ihc-content-bold"><?php _e('Site Title', 'ihc');?></label>
			<input type="text" name="title" value=""/>
		</div>
		<input type="hidden" name="lid" value="<?php echo $data['lid'];?>" />
		<div class="ihc-submit-form ihc-content-pushover-button">
			<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="add_new_site" class="ihc-submit-bttn-fe" />
		</div>
	</form>

</div>
