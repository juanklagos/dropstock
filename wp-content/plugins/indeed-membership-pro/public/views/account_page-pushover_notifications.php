<div class="ihc-ap-wrap">
	<?php if (!empty($data['title'])):?>
		<h3><?php echo do_shortcode($data['title']);?></h3>
	<?php endif;?>
	<?php if (!empty($data['content'])):?>
		<p><?php echo do_shortcode($data['content']);?></p>
	<?php endif;?>
	<form method="post" action="">
		<input type="hidden" name="ihc_pushover_nonce" value="<?php echo wp_create_nonce( 'ihc_pushover_nonce' );?>" />
		<div class="ihc-form-line-register ihc-form-text">
			<label class="ihc-labels-register ihc-content-bold"><?php _e('User Token', 'ihc');?></label>
			<input type="text" name="ihc_pushover_token" value="<?php echo $data['ihc_pushover_token'];?>"/>
		</div>
		<div class="ihc-submit-form ihc-content-pushover-button">
			<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="indeed_submit" class="ihc-submit-bttn-fe" />
		</div>
	</form>
</div>
