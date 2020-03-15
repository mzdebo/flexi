<?php
//Display tags
if ($show_tag) {
 echo flexi_generate_tags($tags_array, 'flexi_tag-default', 'filter_tag') . "<div style='clear:both;'></div>";
}
?>
<div class="flexi_label"><?php echo $toolbar->label(); ?></div>
<?php
//Attach header gallery based based on layout selection
require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/header.php';

if ('scroll' == $navigation || 'button' == $navigation) {

 ?>

 <?php
}
