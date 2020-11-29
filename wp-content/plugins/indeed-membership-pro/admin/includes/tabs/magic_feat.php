<div class="ihc-top-message-new-extension">
	<?php echo _e('Extend your <strong>Ultimate Membership Pro</strong> system with extra features and functionality. Check additional available <strong>Extensions</strong> <a href="https://store.wpindeed.com" target="_blank">here</a>','ihc'); ?>
</div>
<?php
$data['feature_types'] = ihcGetListOfMagicFeatures();
foreach ($data['feature_types'] as $k=>$v):?>
	<div class="ihc-magic-box-wrap <?php echo ($v['enabled']) ? '' : 'ihc-disabled-box';?>">
		<a href="<?php echo $v['link'];?>" <?php if($k == 'new_extension'): echo ' target="_blank" '; endif;?>>
			<div class="ihc-magic-feature <?php echo $k;?> <?php echo $v['extra_class'];?>">
				<div class="ihc-magic-box-icon"><i class="fa-ihc <?php echo $v['icon'];?>"></i></div>
				<div class="ihc-magic-box-title"><?php echo $v['label'];?></div>
				<div class="ihc-magic-box-desc"><?php echo $v['description'];?></div>
			</div>
		</a>
	</div>
<?php endforeach;?>
