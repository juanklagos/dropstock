<?php
if (!empty($_POST['import']) && !empty($_FILES['import_file']) && !empty( $_POST['ihc_import_users_nonce'] ) && wp_verify_nonce( $_POST['ihc_import_users_nonce'], 'ihc_import_users_nonce' ) ){
	////////////////// IMPORT
	$filename = IHC_PATH . 'import.xml';
	move_uploaded_file($_FILES['import_file']['tmp_name'], $filename);
	require_once IHC_PATH . 'classes/import-export/IndeedImport.class.php';
	require_once IHC_PATH . 'classes/import-export/Ihc_Indeed_Import.class.php';
	$import = new Ihc_Indeed_Import();
	$import->setFile($filename);
	$import->run();
}
?>
<div class="ihc-stuffbox">
	<h3><?php _e('Export', 'ihc');?></h3>
	<div class="inside">
		<div class="iump-form-line">
			<span class="iump-labels-special"></span>
			<div class="iump-form-line">
				<span style="font-weight:bold; display:inline-block; width: 25%;"><?php _e('Users', 'ihc');?></span>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#import_users');" />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="import_users" value=0 id="import_users"/>
			</div>
			<div class="iump-form-line">
				<span style="font-weight:bold; display:inline-block; width: 25%;"><?php _e('Settings', 'ihc');?></span>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#import_settings');" />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="import_settings" value=0 id="import_settings"/>
			</div>
			<div class="iump-form-line">
				<span style="font-weight:bold; display:inline-block; width: 25%;"><?php _e('Post Settings', 'ihc');?></span>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#import_postmeta');" />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="import_postmeta" value=0 id="import_postmeta"/>
			</div>
		</div>

		<div class="ihc-hidden-download-link" style="display: none;"><a href="" target="_blank" download>export.xml</a></div>

		<div class="ihc-wrapp-submit-bttn">
			<div class="button button-primary button-large" style="display: inline-block; vertical-align: top;" onClick="ihcMakeExportFile();"><?php _e('Export', 'ihc');?></div>
			<div style="display: inline-block; vertical-align: top;" id="ihc_loading_gif" ><span class="spinner"></span></div>
		</div>
	</div>
</div>

<form action="" method="post" enctype="multipart/form-data">

	<input type="hidden" name="ihc_import_users_nonce" value="<?php echo wp_create_nonce( 'ihc_import_users_nonce' );?>" />

	<div class="ihc-stuffbox">
		<h3><?php _e('Import', 'ihc');?></h3>
		<div class="inside">
			<div class="iump-form-line">
				<span class="iump-labels-special"><?php _e('File', 'ihc');?></span>
				<input type="file" name="import_file" />
			</div>

			<div class="ihc-wrapp-submit-bttn">
				<input type="submit" value="<?php _e('Import', 'ihc');?>" name="import" class="button button-primary button-large">
			</div>
		</div>
	</div>
</form>

<?php
