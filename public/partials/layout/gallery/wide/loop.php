<?php
$data = flexi_image_data('flexi-thumb', $post, $popup);
?>
 <div class="col-sm-<?php echo $column; ?> py-3 px-lg-5 flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>"
    data-tags="<?php echo $tags; ?>">
    <div class='flexi_loop_content flexi_frame_2'>

    <div class="row">
    <div class="col-3">
    <div class="flexi_media <?php echo $data['popup']; ?>">
                    <a
                        <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                        <img class="flexi_image_frame"
                            src="<?php echo esc_url(flexi_image_src('flexi-thumb', $post)); ?>">
                        <?php echo ' <div class="flexi_figcaption" id="flexi_cap_' . get_the_ID() . '"></div>'; ?>
                    </a>
                    </div>
    </div>
    <div class="col-9">
    <div class="row">
    <div class="col">
    <p class="h5"><?php echo $data['title']; ?> </p>
    <p>
    <?php echo flexi_excerpt(20); ?>
</p>

    </div>

    </div></div>
  </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<b><?php echo $data['title']; ?></b>');
    jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_excerpt(); ?>');
});
</script>