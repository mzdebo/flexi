<?php
$data = flexi_image_data('flexi-thumb', $post, $popup);
?>
 <div class="column" flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>"
    data-tags="<?php echo $tags; ?>">
    <div class='flexi_loop_content flexi_frame_2'>

        <div class="ui internally celled grid">
            <div class="row">
                <div class="four wide column">
                <div class="flexi_media <?php echo $data['popup']; ?>">
                    <a
                        <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                        <img class="flexi_image_frame"
                            src="<?php echo esc_url(flexi_image_src('flexi-thumb', $post)); ?>">
                        <?php echo ' <div class="flexi_figcaption" id="flexi_cap_' . get_the_ID() . '"></div>'; ?>
                    </a>
                    </div>
                </div>
                <div class="twelve wide column">

                    <div class="ui stackable equal width grid">
                        <div class="column">

                            <div class="ui basic segment">
                                <h4 class="ui header">A header</h4>
                                <?php echo flexi_excerpt(20); ?>
                                <div class="ui fitted divider"></div>
                                <?php echo flexi_show_icon_grid(); ?>
                            </div>

                        </div>

                        <?php

$c = flexi_custom_field_loop($post, 'gallery', 2);
if ('<div class="ui tiny celled list"></div>' != $c) {
 echo '<div class="column">' . $c . '</div>';
}

?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<b><?php echo $data['title']; ?></b>');
    jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_excerpt(); ?>');
});
</script>