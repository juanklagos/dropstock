<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); 
$galleryOption = new DBDBOption016_GallerySizes($option);
$imagesPerRow = $galleryOption->imagesPerRow();
$imageWidth = $galleryOption->imageWidthPx();
$imageHeight = $galleryOption->imageHeightPx();
$itemWidthPercent = 100/$imagesPerRow;
$spacesPerRow = $imagesPerRow-1;
?>

/* Set the image widths */
.et_pb_gallery_grid .et_pb_gallery_item {
    width: <?php esc_html_e($itemWidthPercent); ?>% !important;
}
.dbdb_divi_2_4_up .et_pb_gallery_grid .et_pb_gallery_item { 
	margin-right: 0 !important; 
}
.et_pb_gallery_grid .column_width,
.et_pb_gallery_grid .et_pb_gallery_image,
.et_pb_gallery_grid .et_pb_gallery_image.portrait img,
.et_pb_gallery_grid .et_pb_gallery_title {
    width: <?php esc_html_e($imageWidth); ?>px !important;
	max-width: 100% !important;
}

/* Justify images in item area - to make images take up full width */
<?php 
for($i=0; $i<$imagesPerRow; $i++) { 
	$leftMarginFraction = $i / ($imagesPerRow-1);
	$itemNum = $i+1; 
	$galleryItemSelector = ".et_pb_gallery_grid .et_pb_gallery_item:nth-child({$imagesPerRow}n+{$itemNum})";
	?>
	<?php esc_html_e($galleryItemSelector); ?> .et_pb_gallery_image,
	<?php esc_html_e($galleryItemSelector); ?> .et_pb_gallery_title {
		margin-left: calc( <?php esc_html_e($leftMarginFraction); ?> * ( 100% - <?php esc_html_e($imageWidth); ?>px ) ) !important;
		margin-right: auto !important;
	}
	<?php 
} 
?>

/* Set the image heights */
.et_pb_gallery_grid .et_pb_gallery_image,
.et_pb_gallery_grid .et_pb_gallery_image.landscape img {
    height: <?php esc_html_e($imageHeight); ?>px !important;
}
.et_pb_gallery_grid .et_pb_gallery_image img {
    min-height: <?php esc_html_e($imageHeight); ?>px;
}

/* Set the spacing between images */
<?php 
	$spaceBetweenItemsCssCalc = "calc( ( 100% - ".$imageWidth*$imagesPerRow."px ) / {$spacesPerRow} )";
?>
.et_pb_gallery_grid .gutter_width { 
	width: <?php esc_html_e($spaceBetweenItemsCssCalc); ?> !important; 
}
.et_pb_gallery_grid .et_pb_gallery_item { 
	margin-bottom: <?php esc_html_e($spaceBetweenItemsCssCalc); ?> !important; 
}

.dbdb_divi_2_4_up .et_pb_gallery_grid .et_pb_gallery_item { 
	clear:none !important; 
}
.dbdb_divi_2_4_up .et_pb_gallery_grid .et_pb_gallery_item:nth-child(<?php esc_html_e($imagesPerRow); ?>n+1) { 
	clear:both !important; 
}

.dbdb_divi_2_4_up .et_pb_gallery_grid .et_pb_gallery_image img { 
	min-height: 0 !important; 
}
.dbdb_divi_2_4_up .et_pb_gallery_grid .et_pb_gallery_image,
.dbdb_divi_2_4_up .et_pb_gallery_grid .et_pb_gallery_image.landscape img
{
    height: auto !important;
}