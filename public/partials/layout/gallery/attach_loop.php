<?php
//If classic page navigation selected
if ('pagenavi' == $navigation) {
 //Attach loop gallery based based on layout selection
 $gallery_layout = flexi_get_option('gallery_layout', 'flexi_image_layout_settings', 'masonry');
 require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $gallery_layout . '/loop.php';
} else {
 //WP_QUERY & loop is executed at includes\flexi_load_more.php
}
