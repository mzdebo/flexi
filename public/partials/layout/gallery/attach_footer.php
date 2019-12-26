<?php
//Attach footer of gallery based based on layout selection
require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/masonry/footer.php';

// AJAX lazy loading
    echo "<div style='clear:both;'></div>";
    echo "<div id='flexi_load_more' style='text-align:center'><a id='load_more_link' class='flexi_load_more pure-button pure-button-primary' style='margin:5px; font-size: 80%;' href='admin-ajax.php?action=flexi_load_more' data-paged='" . $query->max_num_pages . "' data-reset='false' gallery_layout='" . $layout . "' popup='" . $popup . "'>Load More</a></div>";
   // echo "<a id='load_more_reset' class='flexi_load_more' style='margin:5px; font-size: 80%;' href='admin-ajax.php?action=flexi_load_more' data-paged='" . $query->max_num_pages . "' data-reset='true' gallery_layout='" . $layout . "' popup='" . $popup . "'></a>";

?>
<script>
//Load first record on page load
jQuery(document).ready(function() {

    jQuery('#load_more_link').click();
})
</script>