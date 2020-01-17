<?php
$data = flexi_image_data('flexi-thumb', $post);
?>
 <article class="flexi_gallery_child" id="flexi_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
    <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '"'; ?>> <?php echo '<img src="' . esc_url(flexi_image_src('flexi-medium', $post)) . '"></a>'; ?></a>
  </article>
