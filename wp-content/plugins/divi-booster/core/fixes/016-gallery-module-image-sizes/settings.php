<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db016_add_setting($plugin) {  

	list($name, $option) = $plugin->get_setting_bases(__FILE__); 
	$galleryOption = new DBDBOption016_GallerySizes($option);
	
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/change-divi-image-gallery-grid-thumbnail-sizes/'); 
	$plugin->checkbox(__FILE__); ?> Grid layout default image sizes:
<table style="margin-left:50px">
<tr><td>Images per row:</td><td><?php $plugin->numberpicker(__FILE__, 'imagescount', $galleryOption->imagesPerRowDefault(), 1); ?></td></tr>
<tr><td>Image max width:</td><td id="wtfdivi016-width"><?php $plugin->numberpicker(__FILE__, 'imagewidth', $galleryOption->imageWidthPxDefault()); ?>px</td></tr>
<tr><td>Image max height:</td><td><?php $plugin->numberpicker(__FILE__, 'imageheight', $galleryOption->imageHeightPxDefault()); ?>px</td></tr>
</table>
<?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('modules-gallery', 'db016_add_setting');