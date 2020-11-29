<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

// CHECK IF CUSTOM TEMPLTE
$get_enable_email_template = $titan->getOption( 'enable_email_template' );

$get_BodyCommerce_email_footer_text = $titan->getOption( 'BodyCommerce_email_footer_text' );
$get_BodyCommerce_email_footer_alignment = $titan->getOption( 'BodyCommerce_email_footer_alignment' );


$get_BodyCommerce_email_footer_logo = $titan->getOption( 'BodyCommerce_email_footer_logo' );
$get_BodyCommerce_email_footer_logo_attachment = wp_get_attachment_image_src( $get_BodyCommerce_email_footer_logo, $size = 'full', $icon = false );
$footer_logo = $get_BodyCommerce_email_footer_logo_attachment[0]; //DONE
$get_BodyCommerce_email_footer_logo_height = $titan->getOption( 'BodyCommerce_email_footer_logo_height' );
$BodyCommerce_email_footer_logo_link = $titan->getOption( 'BodyCommerce_email_footer_logo_link' );

if ($get_enable_email_template == 1) {

?>
</div>
</td>
</tr>
</table>
<!-- End Content -->
</td>
</tr>
</table>
<!-- End Body -->
</td>
</tr>
</table>
</td>
</tr>
<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit" style="text-align: <?php echo $get_BodyCommerce_email_footer_alignment ?>; padding: 48px;">

															<?php if ($footer_logo == ""){

															}
																else {

														if ($BodyCommerce_email_footer_logo_link == ""){
														?>
															<img src="<?php echo $footer_logo ?>" height="<?php echo $get_BodyCommerce_email_footer_logo_height ?>'">
														<?php
													} else {
													?>
														<a href="<?php echo $BodyCommerce_email_footer_logo_link ?>" target="_blank"><img src="<?php echo $footer_logo ?>" height="<?php echo $get_BodyCommerce_email_footer_logo_height ?>'"></a>
													<?php
													}

													} ?>

															<?php
															if ($get_BodyCommerce_email_footer_text != ""){
															echo $get_BodyCommerce_email_footer_text;
														}
															else {
															echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) );
														}?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- End Footer -->
							</td>
						</tr>
					</table>
				</div>
			</body>
		</html>
<?php
} else {
	?>
</div>
</td>
</tr>
</table>
<!-- End Content -->
</td>
</tr>
</table>
<!-- End Body -->
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" valign="top">
<!-- Footer -->
<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
<tr>
<td valign="top">
<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>
<td colspan="2" valign="middle" id="credit">
<?php echo wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
</td>
</tr>
</table>
</td>
</tr>
</table>
<!-- End Footer -->
</td>
</tr>
</table>
</div>
</body>
</html>
	<?php
}
