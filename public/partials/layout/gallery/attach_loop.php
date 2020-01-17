<?php
$tags = flexi_get_taxonomy_raw($post->ID, 'flexi_tag');

//If classic page navigation selected
if ('pagenavi' == $navigation) {
 //Attach loop gallery based based on layout selection
 require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/loop.php';
} else {
 //WP_QUERY & loop is executed at includes\flexi_load_more.php
}
