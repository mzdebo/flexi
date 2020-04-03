<?php
$data = flexi_image_data('flexi-thumb', $post, $popup);

//echo '<div class="flexi_responsive flexi_gallery_child"<div class="flexi_gallery_grid"  style="position: relative;"><a data-fancybox="flexi_standalone_gallery" class="" href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0">';
//echo '<img class="flexi-fit_cover flexi_image_frame" src="' . esc_url(flexi_image_src('flexi-thumb', $post)) . '">';
//echo '</a></div></div>';

echo '<div class="flexi_responsive flexi_gallery_child" id="flexi_' . get_the_ID() . '"  data-tags="' . $tags . '">';
echo '<div class="flexi_gallery_grid flexi_padding flexi_effect ' . $data['popup'] . '" id="' . $hover_effect . '">';
echo '<div class="flexi-image-wrapper">';
echo '<a data-fancybox="flexi_standalone_gallery" class="" href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0">';
echo '<img src="' . esc_url(flexi_image_src('flexi-medium', $post)) . '">';
echo '</a>';
echo '</div>';
echo "</div>";
echo "</div>";
