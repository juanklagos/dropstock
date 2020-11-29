<?php do_action( 'ump_admin_after_top_menu_add_ons' );?>

<div class="iump-wrapper">

	<div class="col-right">

			<div class="iump-page-title"><?php _e('Ultimate Membership Pro - Filters & Hooks', 'ihc');?></div>

		        <?php if ( $data ):?>
		            <table class="wp-list-table widefat fixed tags ihc-admin-tables" >
										<thead>
				                <tr>
				                    <th class="manage-column"><?php _e('Name', 'ihc');?></th>
						                <th class="manage-column" style="max-width: 10%;"><?php _e('Type', 'ihc');?></th>
				                    <th class="manage-column"><?php _e('Description', 'ihc');?></th>
				                    <th class="manage-column"><?php _e('File', 'ihc');?></th>
				                </tr>
										</thead>
										<tbody>
				            <?php foreach ( $data as $hookName => $hookData ):?>
				                <tr>
				                    <td class="manage-column"><?php echo $hookName;?></td>
						                <td class="manage-column"><?php echo $hookData['type'];?></td>
				                    <td class="manage-column"><?php echo $hookData['description'];?></td>
				                    <td class="manage-column" style="font-size: 9px;">
																<?php if ( $hookData['file'] && is_array( $hookData['file'] ) ):?>
																		<?php foreach ( $hookData['file'] as $file ):?>
																				<div><?php echo $file;?></div>
																		<?php endforeach;?>
																<?php endif;?>
														</td>
				                </tr>
				            <?php endforeach;?>
										</tbody>
										<tfoot>
												<tr>
														<th class="manage-column"><?php _e('Name', 'ihc');?></th>
														<th class="manage-column" style="max-width: 10%;"><?php _e('Type', 'ihc');?></th>
														<th class="manage-column"><?php _e('Description', 'ihc');?></th>
														<th class="manage-column"><?php _e('File', 'ihc');?></th>
												</tr>
										</tfoot>
								</table>
		        <?php endif;?>

	</div>

</div>
