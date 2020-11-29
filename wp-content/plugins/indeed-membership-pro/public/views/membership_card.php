<?php
$data['icon_prin_id'] = rand(1,1000) . 'printdiv';
$data['wrapp_id'] = rand(1,1000) . 'ihccard';
?>

<?php if (!empty($data['metas']['ihc_membership_card_custom_css'])):?>
	<style>
		<?php echo stripslashes($data['metas']['ihc_membership_card_custom_css']);?>
	</style>
<?php endif;?>

<div id="<?php echo $data['wrapp_id'];?>" onmouseover="ihcShowPrint('<?php echo '#' . $data['icon_prin_id'];?>');" onMouseOut="ihcHidePrint('<?php echo '#' . $data['icon_prin_id'];?>');" class="ihc-membership-card-wrapp <?php echo @$data['metas']['ihc_membership_card_size'];?> <?php echo @$data['metas']['ihc_membership_card_template'];?>">

<?php switch ($data['metas']['ihc_membership_card_template']) {
	case 'ihc-membership-card-2':
	case 'ihc-membership-card-3': ?>
		<div class="ihc-membership-card-img">
			<div class="ihc-membership-card-image">
				<?php if (!empty($data['metas']['ihc_membership_card_image'])):?>
					<img src="<?php echo $data['metas']['ihc_membership_card_image'];?>" class="" />
				<?php endif;?>
			</div>
		</div>
		<div class="ihc-membership-card-content">
			<div class="ihc-membership-card-full-name">
				<?php echo @$data['full_name'];?>
			</div>
			<?php if (!empty($data['metas']['ihc_membership_member_since_enable'])):?>
				<div class="ihc-membership-card-member-since">
					<label><?php echo @$data['metas']['ihc_membership_member_since_label'];?></label><span class="ihc-membership-card-data"> <?php echo @$data['member_since'];?></span>
				</div>
			<?php endif;?>
			<?php if (!empty($data['metas']['ihc_membership_member_show_uid'])):?>
				<div class="ihc-membership-card-uid">
					<label><?php echo @$data['metas']['ihc_membership_member_uid_label'];?></label><span class="ihc-membership-card-data"><?php echo @$current_user->ID;?></span>
				</div>
			<?php endif;?>
			<div class="ihc-membership-card-level">
				<label><?php echo @$data['metas']['ihc_membership_member_level_label'];?></label><span class="ihc-membership-card-data"> <?php echo @$level_data['label'];?></span>
			</div>
			<?php if (!empty($data['metas']['ihc_membership_member_level_expire'])):?>
				<div class="ihc-membership-level-expire">
					<label><?php echo @$data['metas']['ihc_membership_member_level_expire_label'];?></label><span class="ihc-membership-card-data"> <?php echo ihc_convert_date_to_us_format(@$level_data['expire_time']);?></span>
				</div>
			<?php endif;?>
		</div>
	<?php
			break;
	?>
	<?php default: ?>
	<div class="ihc-membership-card-content">
		<div class="ihc-membership-card-full-name">
			<?php echo @$data['full_name'];?>
		</div>
		<?php if (!empty($data['metas']['ihc_membership_member_since_enable'])):?>
			<div class="ihc-membership-card-member-since">
				<label><?php echo @$data['metas']['ihc_membership_member_since_label'];?></label><span class="ihc-membership-card-data"> <?php echo @$data['member_since'];?></span>
			</div>
		<?php endif;?>
        <?php if (!empty($data['metas']['ihc_membership_member_show_uid'])):?>
				<div class="ihc-membership-card-uid">
					<label><?php echo @$data['metas']['ihc_membership_member_uid_label'];?></label><span class="ihc-membership-card-data"><?php echo @$current_user->ID;?></span>
				</div>
			<?php endif;?>
		<div class="ihc-membership-card-level">
			<label><?php echo @$data['metas']['ihc_membership_member_level_label'];?></label><span class="ihc-membership-card-data"> <?php echo @$level_data['label'];?></span>
		</div>
		<?php if (!empty($data['metas']['ihc_membership_member_level_expire'])):?>
			<div class="ihc-membership-level-expire">
				<label><?php echo @$data['metas']['ihc_membership_member_level_expire_label'];?></label><span class="ihc-membership-card-data"> <?php echo ihc_convert_date_to_us_format(@$level_data['expire_time']);?></span>
			</div>
		<?php endif;?>
	</div>
	<div class="ihc-membership-card-img">
		<div class="ihc-membership-card-image">
			<?php if (!empty($data['metas']['ihc_membership_card_image'])):?>
				<img src="<?php echo $data['metas']['ihc_membership_card_image'];?>" class="" />
			<?php endif;?>
		</div>
	</div>
	<?php } ?>
	<div class="ihc-print-icon" id="<?php echo $data['icon_prin_id'];?>"><i class="fa-ihc fa-print-ihc" onClick="ihcHidePrint('<?php echo '#' . $data['icon_prin_id'];?>');" data-id-to-print="<?php echo $data['wrapp_id'];?>" ></i></div>

</div>
