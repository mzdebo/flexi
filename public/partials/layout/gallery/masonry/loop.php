<div class="flexi_masonry-item flexi_gallery_child" id="flexi_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
    <?php
$data = flexi_image_data('medium', $post);
echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"><img src="' . esc_url(flexi_image_src('medium', $post)) . '"  class="flexi_masonry-content">';
echo ' <flexi_figcaption><b>' . $data['title'] . '</b><br>' . get_the_excerpt() . '</flexi_figcaption></a>';
?>
</div>