<?php
$data = flexi_image_data('flexi-thumb', $post);
?>

<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">

      <div class='flexi_loop_content flexi_frame_2'>

            <div class="flexi_media">
                   <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                  <img class="flexi-fit_cover flexi_image_frame" src="<?php echo esc_url(flexi_image_src('flexi-thumb', $post)); ?>">
                  <?php echo ' <flexi_figcaption><b>' . $data['title'] . '</b><br>' . flexi_excerpt() . '</flexi_figcaption>'; ?>
                   </a>
            </div>
            <div class="flexi_group">
                  <div class="flexi_title"><?php echo $data['title']; ?></div>
                  <div class="flexi_p"><?php echo flexi_excerpt(20); ?></div>
                  <div class="flexi_bar">
                  <span class="dashicons dashicons-admin-users"></span>

                <?php
$nonce = wp_create_nonce("flexi_ajax_delete");
$link  = 'admin-ajax.php?action=flexi_ajax_delete&post_id=' . get_the_ID() . '&nonce=' . $nonce;
?>
                <a class="flexi_ajax_delete" data-post_id='<?php echo get_the_ID(); ?>' data-nonce='<?php echo $nonce; ?>' href='#'> <span class="dashicons dashicons-trash"></span></a>
                  <a style="text-decoration:none" href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'><span class="dashicons dashicons-edit"></span></a>
                  </div>


            </div>
      </div>

</div>


