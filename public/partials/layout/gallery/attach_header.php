<?php
//Display tags
if ($show_tag) {
 echo flexi_generate_tags($tags_array, 'flexi_tag-blue', 'filter_tag') . "<div style='clear:both;'></div>";
}
//$navigation = flexi_get_option('navigation', 'flexi_image_layout_settings', 'scroll');
//Attach header gallery based based on layout selection
require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/header.php';

if ('scroll' == $navigation || 'button' == $navigation) {

 ?>


 <?php
}
