<?php
$data = flexi_image_data('flexi-thumb', $post);
?>

<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">

    <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
    <img class="flexi-fit_cover flexi_image_frame" src="<?php echo esc_url(flexi_image_src('flexi-medium', $post)); ?>">
    <?php echo ' <flexi_figcaption><b>' . $data['title'] . '</b><br>' . get_the_excerpt() . '</flexi_figcaption>'; ?>
</a>

</div>

