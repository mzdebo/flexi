<?php
//Attach footer of gallery based based on layout selection
require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/footer.php';

//If AJAX loading is enabled

if ('scroll' == $navigation || 'button' == $navigation) {
// AJAX lazy loading
 echo "<div style='clear:both;'></div>";
 echo "<div id='flexi_load_more' style='text-align:center'><a id='load_more_link' class='flexi_load_more pure-button pure-button-primary' style='margin:5px; font-size: 80%;' href='#'>Load More</a></div>";
 echo "<div id='reset' style='display:none'>false</div>";
 ?>
<div id='flexi_loader' style='display: none;text-align:center;'>
 <img src="<?php echo FLEXI_PLUGIN_URL . '/public/images/loading.gif'; ?>">

 </div>
<a id='abc' class="xyz">fffff</a>

<script>
//Load first record on page load
jQuery(document).ready(function() {
    jQuery('#load_more_link').click();

})
</script>
<?php
} else {
 //Load basic page loading with other plugin support
 if (function_exists('wp_pagenavi')) {
  echo "" . wp_pagenavi(array('query' => $query));
 }

}
echo "<div id='gallery_layout' style='display:none'>" . $layout . "</div>";
echo "<div id='popup' style='display:none'>" . $popup . "</div>";
echo "<div id='album' style='display:none'>" . $album . "</div>";
echo "<div id='max_paged' style='display:none'>" . $query->max_num_pages . "</div>";
echo "<div id='search' style='display:none'>" . $search . "</div>";
echo "<div id='postsperpage' style='display:none'>" . $postsperpage . "</div>";
echo "<div id='column' style='display:none'>" . $column . "</div>";
echo "<div id='orderby' style='display:none'>" . $orderby . "</div>";
echo "<div id='user' style='display:none'>" . $user . "</div>";
echo "<div id='keyword' style='display:none'>" . $keyword . "</div>";
echo "<div id='padding' style='display:none'>" . $padding . "</div>";
echo "<div id='hover_effect' style='display:none'>" . $hover_effect . "</div>";
echo "<div id='hover_caption' style='display:none'>" . $hover_caption . "</div>";
?>