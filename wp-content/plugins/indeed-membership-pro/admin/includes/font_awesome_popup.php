<?php
$font_awesome = Ihc_Db::get_font_awesome_codes();
?>
<?php foreach ($font_awesome as $base_class => $code):?>
	<div class="ihc-font-awesome-popup-item" data-class="<?php echo $base_class;?>" data-code="<?php echo $code;?>"><i class="fa-ihc-preview fa-ihc <?php echo $base_class;?>"></i></div>
<?php endforeach;?>

