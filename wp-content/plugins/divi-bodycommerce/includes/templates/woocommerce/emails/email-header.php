<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

// CHECK IF CUSTOM TEMPLTE
$get_enable_email_template = $titan->getOption( 'enable_email_template' );

$get_BodyCommerce_email_header_logo = $titan->getOption( 'BodyCommerce_email_header_logo' );
$get_BodyCommerce_email_header_logo_attachment = wp_get_attachment_image_src( $get_BodyCommerce_email_header_logo, $size = 'full', $icon = false);
if( is_array($get_BodyCommerce_email_header_logo_attachment) ) {
$header_logo = $get_BodyCommerce_email_header_logo_attachment[0];
} else {
	$header_logo = $get_BodyCommerce_email_header_logo_attachment;
}


$get_BodyCommerce_email_header_logo_height = $titan->getOption( 'BodyCommerce_email_header_logo_height' );
$get_BodyCommerce_email_header_alignment = $titan->getOption( 'BodyCommerce_email_header_alignment' );

if ($get_enable_email_template == 1) {

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						<div id="template_header_image">
							<?php
							if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
								echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
							}
							?>
						</div>
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
							<tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
										<tr>
											<td id="header_wrapper" style="text-align: <?php echo $get_BodyCommerce_email_header_alignment ?>">
												<?php if ($header_logo == "")
												{}
													else {?>
												<img src="<?php echo $header_logo ?>" height="<?php echo $get_BodyCommerce_email_header_logo_height ?>'">
											</br>
											<?php } ?>
												<h1><?php echo $email_heading; ?></h1>
											</td>
										</tr>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
										<tr>
											<td valign="top" id="body_content">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tr>
														<td valign="top">
															<div id="body_content_inner">
<?php }
else {
	?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
			<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
		</head>
		<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
			<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
				<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
					<tr>
						<td align="center" valign="top">
							<div id="template_header_image">
								<?php
								if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
									echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
								}
								?>
							</div>
							<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
								<tr>
									<td align="center" valign="top">
										<!-- Header -->
										<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
											<tr>
												<td id="header_wrapper">
													<h1><?php echo $email_heading; ?></h1>
												</td>
											</tr>
										</table>
										<!-- End Header -->
									</td>
								</tr>
								<tr>
									<td align="center" valign="top">
										<!-- Body -->
										<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
											<tr>
												<td valign="top" id="body_content">
													<!-- Content -->
													<table border="0" cellpadding="20" cellspacing="0" width="100%">
														<tr>
															<td valign="top">
																<div id="body_content_inner">
																	<?php
}
