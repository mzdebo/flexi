<?php
$data = flexi_image_data('flexi-thumb', $post, $popup);
?>

<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">

      <div class='flexi_loop_content flexi_frame_2'>

            <div class="flexi_media <?php echo $data['popup']; ?>">
                   <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                        <img class="flexi-fit_cover flexi_image_frame" src="<?php echo esc_url(flexi_image_src('flexi-thumb', $post)); ?>">
                        <?php echo ' <div class="flexi_figcaption" id="flexi_cap_' . get_the_ID() . '"></div>'; ?>
                   </a>
            </div>
            <div class="flexi_group">
                  <div class="flexi_title"><?php echo $data['title']; ?></div>
                  <div class="flexi_p"><?php echo flexi_excerpt(20); ?>
<?php if (get_post_status() == 'draft' || get_post_status() == "pending") {?><div class="flexi_badge"> <?php echo __("Under Review", "flexi"); ?></div><?php }?></div>
                  <div class="flexi_list_tags"><?php flexi_list_tags($post);?></div>
                  <div class="flexi_bar"><?php echo flexi_show_icon_grid(); ?></div>
            </div>
      </div>

</div>
<script>
jQuery(document).ready(function() {
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<b><?php echo $data['title']; ?></b>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_excerpt(); ?>');
});

</script>
