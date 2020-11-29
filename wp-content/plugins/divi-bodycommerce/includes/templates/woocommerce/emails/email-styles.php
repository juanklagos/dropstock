<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
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

if ($get_enable_email_template == 1) {

// Appearance
$get_BodyCommerce_email_bg_color = $titan->getOption( 'BodyCommerce_email_bg_color' ); //DONE
$get_BodyCommerce_email_accent_color = $titan->getOption( 'BodyCommerce_email_accent_color' ); //DONE
$get_BodyCommerce_email_body_bg_color = $titan->getOption( 'BodyCommerce_email_body_bg_color' ); //DONE

$BodyCommerce_enable_body_shadow = $titan->getOption( 'BodyCommerce_enable_body_shadow' );
$BodyCommerce_enable_body_border = $titan->getOption( 'BodyCommerce_enable_body_border' );

$get_BodyCommerce_email_text_color = $titan->getOption( 'BodyCommerce_email_text_color' ); //DONE
$get_BodyCommerce_email_page_width = $titan->getOption( 'BodyCommerce_email_page_width' ); //DONE
$get_BodyCommerce_email_border_radius = $titan->getOption( 'BodyCommerce_email_border_radius' );
$get_BodyCommerce_email_h1_font_size = $titan->getOption( 'BodyCommerce_email_h1_font_size' ); //DONE
$get_BodyCommerce_email_h2_font_size = $titan->getOption( 'BodyCommerce_email_h2_font_size' ); //DONE
$get_BodyCommerce_email_h3_font_size = $titan->getOption( 'BodyCommerce_email_h3_font_size' ); //DONE
$get_BodyCommerce_email_p_font_size = $titan->getOption( 'BodyCommerce_email_p_font_size' ); //DONE
$get_BodyCommerce_email_paragraph_line_height = $titan->getOption( 'BodyCommerce_email_paragraph_line_height' );

// Header
$get_BodyCommerce_email_header_logo = $titan->getOption( 'BodyCommerce_email_header_logo' );
$get_BodyCommerce_email_header_logo_attachment = wp_get_attachment_image_src( $get_BodyCommerce_email_header_logo );
$header_logo = $get_BodyCommerce_email_header_logo_attachment[0]; //DONE
$get_BodyCommerce_email_header_logo_height = $titan->getOption( 'BodyCommerce_email_header_logo_height' ); //DONE
$get_BodyCommerce_email_header_logo_padding_below = $titan->getOption( 'BodyCommerce_email_header_logo_padding_below' ); //DONE
$get_BodyCommerce_email_header_bg_color = $titan->getOption( 'BodyCommerce_email_header_bg_color' ); //DONE
$get_BodyCommerce_email_header_text_color = $titan->getOption( 'BodyCommerce_email_header_text_color' ); //DONE
$get_BodyCommerce_email_header_alignment = $titan->getOption( 'BodyCommerce_email_header_alignment' ); //DONE

// Order Details
$get_BodyCommerce_email_table_border_width = $titan->getOption( 'BodyCommerce_email_table_border_width' ); //DONE
$get_BodyCommerce_email_table_border_color = $titan->getOption( 'BodyCommerce_email_table_border_color' ); //DONE
$get_BodyCommerce_email_table_bg_color = $titan->getOption( 'BodyCommerce_email_table_bg_color' ); //DONE

// Footer
$get_BodyCommerce_email_footer_logo = $titan->getOption( 'BodyCommerce_email_footer_logo' );
$get_BodyCommerce_email_footer_logo_attachment = wp_get_attachment_image_src( $get_BodyCommerce_email_footer_logo );
$footer_logo = $get_BodyCommerce_email_footer_logo_attachment[0]; //DONE

$get_BodyCommerce_email_footer_logo_height = $titan->getOption( 'BodyCommerce_email_footer_logo_height' ); //DONE
$get_BodyCommerce_email_footer_bg_color = $titan->getOption( 'BodyCommerce_email_footer_bg_color' ); //DONE
$get_BodyCommerce_email_footer_text_color = $titan->getOption( 'BodyCommerce_email_footer_text_color' ); //DONE
$get_BodyCommerce_email_footer_alignment = $titan->getOption( 'BodyCommerce_email_footer_alignment' ); //DONE
$get_BodyCommerce_email_footer_text = $titan->getOption( 'BodyCommerce_email_footer_text' );

// Load colors
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );


if ($BodyCommerce_enable_body_shadow == 1) {$BodyCommerce_enable_body_shadow_dis = "box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;"; } else {$BodyCommerce_enable_body_shadow_dis = ""; };
if ($BodyCommerce_enable_body_border == 1) {$BodyCommerce_enable_body_border_dis = "border: 1px solid " . esc_attr( $bg_darker_10 )  . ";"; } else {$BodyCommerce_enable_body_border_dis = ""; };


// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
body {
	background-color: <?php if ($get_BodyCommerce_email_bg_color != ""){echo $get_BodyCommerce_email_bg_color;}else {echo esc_attr( $bg );} ?>;
	padding: 0;
}

#wrapper {
	background-color: <?php if ($get_BodyCommerce_email_bg_color != ""){echo $get_BodyCommerce_email_bg_color;}else {echo esc_attr( $body );} ?>;
	margin: 0;
	padding: 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	<?php echo $BodyCommerce_enable_body_shadow_dis ?>
	background-color: <?php echo esc_attr( $body ); ?>;
	<?php echo $BodyCommerce_enable_body_border_dis ?>
	border-radius: 3px !important;
	width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
	max-width: <?php echo $get_BodyCommerce_email_page_width; ?>;
}

#template_header {
	background-color: <?php if ($get_BodyCommerce_email_header_bg_color != ""){echo $get_BodyCommerce_email_header_bg_color;}else {echo esc_attr( $base );} ?>;
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
}

#template_header h1,
#template_header h1 a {
	color: <?php if ($get_BodyCommerce_email_header_text_color != ""){echo $get_BodyCommerce_email_header_text_color;}else {echo esc_attr( $base_text );} ?>;
}

#template_footer td {
	padding: 0;
	-webkit-border-radius: 6px;
	width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
}

#template_header_image img {
	margin-left: 0;
	margin-right: 0;
}

#template_footer td {
	padding: 0;
	border-radius: 6px;
}

#template_footer #credit {
	border:0;
		color: <?php if ($get_BodyCommerce_email_footer_text_color != ""){echo $get_BodyCommerce_email_footer_text_color;}else {echo esc_attr( $base_lighter_40 );} ?>;
		font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
		font-size: 12px;
		line-height: 150%;
		text-align: center;
		padding: 24px 0;
}

#template_footer #credit p {
	margin: 0 0 16px;
}

#body_content {
	background-color: <?php if ($get_BodyCommerce_email_body_bg_color != ""){echo $get_BodyCommerce_email_body_bg_color;}else {echo esc_attr( $body );} ?>;
}

#body_content table td {
	padding: 48px;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content table td td {
	padding: 12px;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content table td th {
	padding: 12px;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content p {
	margin: 0 0 16px;
	<?php if ($get_BodyCommerce_email_text_color != ""){?> color:  <?php echo $get_BodyCommerce_email_text_color;}else {} ?>;
}

#body_content_inner {
	color: <?php if ($get_BodyCommerce_email_text_color != ""){echo $get_BodyCommerce_email_text_color;}else {echo esc_attr( $text_lighter_20 );} ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: <?php echo $get_BodyCommerce_email_p_font_size ?>px;
	line-height: <?php $get_BodyCommerce_email_paragraph_line_height ?>em;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: <?php echo $get_BodyCommerce_email_table_border_width; ?>px solid <?php if ($get_BodyCommerce_email_table_border_color != ""){echo $get_BodyCommerce_email_table_border_color;}else{ echo esc_attr( $body_darker_10 );} ?>;
	<?php if ($get_BodyCommerce_email_table_bg_color != ""){?> background-color: <?php echo $get_BodyCommerce_email_table_bg_color;}else {} ?>;
	vertical-align: middle;
}

.text {
	color: <?php if ($get_BodyCommerce_email_text_color != ""){echo $get_BodyCommerce_email_text_color;}else {echo esc_attr( $text );} ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php if ($get_BodyCommerce_email_accent_color != ""){echo $get_BodyCommerce_email_accent_color;}else {echo esc_attr( $base );} ?>;
}

#header_wrapper {
	padding: 36px 48px;
	display: block;
	<?php if ($get_BodyCommerce_email_header_bg_color != ""){?> background-color: <?php echo $get_BodyCommerce_email_header_bg_color;}else {} ?>;
	text-align:  <?php echo $get_BodyCommerce_email_header_alignment; ?>;
}


h1 {
	color: <?php if ($get_BodyCommerce_email_header_text_color != ""){echo $get_BodyCommerce_email_header_text_color;}else {echo esc_attr( $base );} ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: <?php $get_BodyCommerce_email_h1_font_size ?>px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
	-webkit-font-smoothing: antialiased;
		text-align:  <?php echo $get_BodyCommerce_email_header_alignment; ?>;
}

h2 {
	color: <?php if ($get_BodyCommerce_email_accent_color != ""){echo $get_BodyCommerce_email_accent_color;}else {echo esc_attr( $base );} ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: <?php $get_BodyCommerce_email_h2_font_size ?>px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php if ($get_BodyCommerce_email_accent_color != ""){echo $get_BodyCommerce_email_accent_color;}else {echo esc_attr( $base );} ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: <?php $get_BodyCommerce_email_h3_font_size ?>px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php if ($get_BodyCommerce_email_accent_color != ""){echo $get_BodyCommerce_email_accent_color;}else {echo esc_attr( $base );} ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	line-height: 100%;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	height: <?php echo $get_BodyCommerce_email_header_logo_height; ?>;
}

#header_wrapper img {
	padding: 0px 0px <?php echo $get_BodyCommerce_email_header_logo_padding_below; ?>px 0px;
}

#template_body {
width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
max-width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
}

#template_footer {
width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
max-width: <?php echo $get_BodyCommerce_email_page_width; ?>px;
background-color: <?php echo $get_BodyCommerce_email_footer_bg_color; ?>;
}
<?php

}
else {

// Load colors.
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link = wc_hex_is_light( $base ) ? $base : $base_text;
if ( wc_hex_is_light( $body ) ) {
	$link = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
#wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
	margin: 0;
	padding: 70px 0 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;
	background-color: <?php echo esc_attr( $body ); ?>;
	border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
	border-radius: 3px !important;
}

#template_header {
	background-color: <?php echo esc_attr( $base ); ?>;
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#template_header h1,
#template_header h1 a {
	color: <?php echo esc_attr( $base_text ); ?>;
}

#template_footer td {
	padding: 0;
	-webkit-border-radius: 6px;
}

#template_footer #credit {
	border:0;
	color: <?php echo esc_attr( $base_lighter_40 ); ?>;
	font-family: Arial;
	font-size:12px;
	line-height:125%;
	text-align:center;
	padding: 0 48px 48px 48px;
}

#body_content {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#body_content table td {
	padding: 48px 48px 0;
}

#body_content table td td {
	padding: 12px;
}

#body_content table td th {
	padding: 12px;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
}

#body_content p {
	margin: 0 0 16px;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 14px;
	line-height: 150%;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
	vertical-align: middle;
}

.address {
	padding:12px 12px 0;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
}

.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php echo esc_attr( $base ); ?>;
}

#header_wrapper {
	padding: 36px 48px;
	display: block;
}

h1 {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
	text-shadow: 0 1px 0 <?php echo esc_attr( $base_lighter_20 ); ?>;
}

h2 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 130%;
	margin: 0 0 18px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php echo esc_attr( $link ); ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	vertical-align: middle;
	margin-<?php echo is_rtl() ? 'left' : 'right'; ?>: 10px;
}
<?php
}
