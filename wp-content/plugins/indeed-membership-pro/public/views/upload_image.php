<style>

.ihc-avatar-trigger .cropControls .cropControlUpload{

}
.ihc-avatar-trigger .cropControls .cropControlUpload:before{

}
.ihc-user-avatar-wrapp{
    width: 150px;
    height: 150px;
}


</style>
<?php wp_enqueue_style( 'ihc-croppic_css', IHC_URL . 'assets/css/croppic.css' );?>
<?php wp_enqueue_script( 'ihc-jquery_mousewheel', IHC_URL . 'assets/js/jquery.mousewheel.min.js', array(), null );?>
<?php wp_enqueue_script( 'ihc-croppic', IHC_URL . 'assets/js/croppic.js', array(), null );?>
<?php wp_enqueue_script( 'ihc-image_croppic', IHC_URL . 'assets/js/image_croppic.js', array(), null );?>

<script>
jQuery( document ).ready( function(){
    IhcAvatarCroppic.init({
        triggerId					           : '<?php echo 'js_ihc_trigger_avatar' . $data['rand'];?>',
        saveImageTarget		           : '<?php echo IHC_URL . 'public/ajax-upload.php';?>',
        cropImageTarget              : '<?php echo IHC_URL . 'public/ajax-upload.php';?>',
        imageSelectorWrapper         : '.ihc-upload-image-wrapp',
        hiddenInputSelector          : '[name=<?php echo $data['name'];?>]',
        imageClass                   : 'ihc-member-photo',
        removeImageSelector          : '<?php echo '#ihc_upload_image_remove_bttn_' . $data['rand'];?>',
		    buttonId 					           : 'ihc-avatar-button',
		    buttonLabel 			           : '<?php echo __('Upload', 'ihc');?>',
    })
})
</script>
<div class="ihc-upload-image-wrapper">

    <div class="ihc-upload-image-wrapp" >
        <?php if ( !empty($data['imageUrl']) ):?>
            <img src="<?php echo $data['imageUrl'];?>" class="<?php echo $data['imageClass'];?>" />
        <?php else:?>
            <?php if ( $data['name']=='ihc_avatar' ):?>
                <div class="ihc-no-avatar ihc-member-photo"></div>
            <?php endif;?>
        <?php endif;?>
        <div class="ihc-clear"></div>
    </div>
    <div class="ihc-content-left">
    	 <div class="ihc-avatar-trigger" id="<?php echo 'js_ihc_trigger_avatar' . $data['rand'];?>" >
         	<div id="ihc-avatar-button" class="ihc-upload-avatar"><?php _e('Upload', 'ihc');?></div>
         </div>
        <span style="visibility: hidden;" class="ihc-upload-image-remove-bttn" id="<?php echo 'ihc_upload_image_remove_bttn_' . $data['rand'];?>"><?php _e('Remove', 'ihc');?></span>
    </div>
    <input type="hidden" value="<?php echo $data['value'];?>" name="<?php echo $data['name'];?>" id="<?php echo 'ihc_upload_hidden_' . $data['rand'];?>" data-new_user="<?php echo ( $data['user_id'] == -1 ) ? 1 : 0;?>" />

    <?php if (!empty($data['sublabel'])):?>
        <label class="iump-form-sublabel"><?php echo ihc_correct_text($data['sublabel']);?></label>
    <?php endif;?>
</div>
