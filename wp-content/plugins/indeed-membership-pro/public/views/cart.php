<div id="ihc_cart_wrapper">
	<?php if (!empty($data['show_full_cart'] )):?>
	<div class="iump-level-details-register <?php echo $data['template'];?>">
		<div class="ihc-order-title"><?php _e('Payment details', 'ihc');?></div>



		<?php if ($trialObject->isTrialActive()):?>
				<div>
						<span class="iump-level-details-register-name"><?php echo __('Trial Subscription ', 'ihc');?>(<?php echo $trialObject->getDurationValue() . ' ' . $trialObject->getDurationType(false);?>)</span>
						<span class="iump-level-details-register-price"><?php echo $trialObject->getInitialTrialPrice(false);?></span>
						<div class="iump-clear"></div>
				</div>

				<?php if (isset($data['total_taxes']) && !empty($trialObject->getTaxes())):?>
					<div id="ihc_taxes_wrapper" class="iump-tax-wrapper">
						<?php if (!empty($trialObject->getTaxes()['items'] )): ?>
							<div class="ihc-taxes-content">
								<?php foreach ($trialObject->getTaxes()['items'] as $k=>$v):?>
									<div class="iump-level-subdetails-register-name"><?php echo $v['label']; ?></div>
									<div class="iump-level-subdetails-register-price"><?php echo $v['print_value'];?></div>
		                            <div class="iump-clear"></div>
								<?php endforeach;?>
								<div class="iump-clear"></div>

							</div>
						<?php endif;?>
						<span class="iump-level-details-register-name"><?php echo __('Total Trial Taxes:', 'ihc');?></span>
						<span class="iump-level-details-register-price">+<?php echo $trialObject->getTaxes()['print_total'];?></span>
						<div class="iump-clear"></div>


					</div>
				<?php endif;?>

				<div class="iump-totalprice-wrapper">
						<span class="iump-level-details-register-name"><?php echo __('Full Trial price: ', 'ihc');?></span>
						<span class="iump-level-details-register-price"><?php echo $trialObject->getTrialPrice(false);?></span>
						<div class="iump-clear"></div>
				</div>

                    <!-- LEVEL PRICE -->
                <span class="iump-level-details-register-name"><?php echo sprintf( __( '%s' ), $data['level_label'] );?></span>
                <span class="iump-level-details-register-price"><?php echo $data['level_price'];?></span>
                <div class="iump-clear"></div>

                <!-- DISCOUNT VALUE --->
                <?php if (isset($data['discount_value'])):?>
                    <div class="iump-discount-wrapper">
                        <span class="iump-level-details-register-name"><?php echo __('Discount: ', 'ihc');?></span>
                        <span class="iump-level-details-register-price"><?php echo $data['discount_value'];?></span>
                    </div>
                <?php endif;?>
                <div class="iump-clear"></div>

                <!-- TAXES VALUE -->
                <?php if (isset($data['total_taxes']) && !empty($data['print_taxes'])):?>
                    <div id="ihc_taxes_wrapper" class="iump-tax-wrapper" >
                        <?php if (!empty($data['taxes_details'])):?>
                            <div class="ihc-taxes-content">
                                <?php foreach ($data['taxes_details'] as $k=>$v):?>
                                    <div class="iump-level-subdetails-register-name"><?php echo sprintf( __( '%s' ), $data['level_label'] );?></div>
                                    <div class="iump-level-subdetails-register-price"><?php echo $v['print_value'];?></div>
                                    <div class="iump-clear"></div>
                                <?php endforeach;?>
                                <div class="iump-clear"></div>

                            </div>
                        <?php endif;?>
                        <span class="iump-level-details-register-name"><?php echo __('Total Taxes:', 'ihc');?></span>
                        <span class="iump-level-details-register-price">+<?php echo $data['total_taxes'];?></span>
                        <div class="iump-clear"></div>
                    </div>
                <?php endif;?>
                <div class="iump-clear"></div>


				<?php if (isset($data['final_price'])):?>
					  <div class="iump-totalprice-wrapper">
								<span class="iump-level-details-register-name"><?php echo __('Price after trial period: ', 'ihc');?></span>
								<span class="iump-level-details-register-price"><?php echo $data['final_price'];?></span>
								<div class="iump-clear"></div>
					  </div>
				<?php endif;?>
		<?php else :?>

        	                    <!-- LEVEL PRICE -->
                <span class="iump-level-details-register-name"><?php echo sprintf( __( '%s' ), $data['level_label'] );?></span>
                <span class="iump-level-details-register-price"><?php echo $data['level_price'];?></span>
                <div class="iump-clear"></div>

                <!-- DISCOUNT VALUE --->
                <?php if (isset($data['discount_value'])):?>
                    <div class="iump-discount-wrapper">
                        <span class="iump-level-details-register-name"><?php echo __('Discount: ', 'ihc');?></span>
                        <span class="iump-level-details-register-price"><?php echo $data['discount_value'];?></span>
                    </div>
                <?php endif;?>
                <div class="iump-clear"></div>

                <!-- TAXES VALUE -->
                <?php if (isset($data['total_taxes']) && !empty($data['print_taxes'])):?>
                    <div id="ihc_taxes_wrapper" class="iump-tax-wrapper" >
                        <?php if (!empty($data['taxes_details'])):?>
                            <div class="ihc-taxes-content">
                                <?php foreach ($data['taxes_details'] as $k=>$v):?>
                                    <div class="iump-level-subdetails-register-name"><?php echo $v['label']; ?></div>
                                    <div class="iump-level-subdetails-register-price"><?php echo $v['print_value'];?></div>
                                    <div class="iump-clear"></div>
                                <?php endforeach;?>
                                <div class="iump-clear"></div>

                            </div>
                        <?php endif;?>
                        <span class="iump-level-details-register-name"><?php echo __('Total Taxes:', 'ihc');?></span>
                        <span class="iump-level-details-register-price">+<?php echo $data['total_taxes'];?></span>
                        <div class="iump-clear"></div>
                    </div>
                <?php endif;?>
                <div class="iump-clear"></div>

			<!-- FINAL PRICE -->
			<?php if (isset($data['final_price'])):?>
			  <div class="iump-totalprice-wrapper">
						<span class="iump-level-details-register-name"><?php echo __('Final Price: ', 'ihc');?></span>
						<span class="iump-level-details-register-price"><?php echo $data['final_price'];?></span>
						<div class="iump-clear"></div>
			  </div>
			<?php endif;?>
			<div class="iump-clear"></div>
		<?php endif;?>



	</div>
	<?php endif;?>
<input type="hidden" id="iumpfinalglobalp" value="<?php echo @$data['price_number'];?>" />
<input type="hidden" id="iumpfinalglobalc" value="<?php echo @$currency;?>" />
<input type="hidden" id="iumpfinalglobal_ll" value="<?php echo sprintf( __( '%s' ), @$data['level_label'] );?>" />
<input type="hidden" id="iump_site_name" value="<?php echo get_option('blogname');?>" />
</div>
