<?php
//Displays Toolbar
$toolbar = new Flexi_Gallery_Toolbar();
?>
<div class="flexi_label"><?php echo $toolbar->label(); ?></div>

<?php
//Display tags
if ($show_tag) {
 echo flexi_generate_tags($tags_array, 'tiny ui tag label', 'filter_tag') . "<div style='clear:both;'></div>";
}
?>

<?php
//Attach header gallery based based on layout selection
require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/header.php';

if ('scroll' == $navigation || 'button' == $navigation) {

 ?>

 <?php
}
