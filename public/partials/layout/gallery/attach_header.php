<?php
$navigation = flexi_get_option('navigation', 'flexi_image_layout_settings', 'scroll');
//Attach header gallery based based on layout selection
$gallery_layout = flexi_get_option('gallery_layout', 'flexi_image_layout_settings', 'masonry');
require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $gallery_layout . '/header.php';
if ('scroll' == $navigation || 'button' == $navigation) {
 ?>
<div id="flexi_main_loop" style="width:100%"></div>
<div id='flexi_loader' style='display: none;text-align:center;'>
    <img src="<?php echo FLEXI_PLUGIN_URL . '/public/images/loading.gif'; ?>">

</div>
<?php
}

?>