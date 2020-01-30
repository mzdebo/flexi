<?php
$data = flexi_image_data('flexi-thumb', $post);
?>

<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">

<div class="flexi_effect" id="flexi_effect_1">


      <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
     <img class="flexi-fit_cover flexi_image_frame"  src="<?php echo esc_url(flexi_image_src('flexi-medium', $post)); ?>">
      <?php echo ' <flexi_figcaption><b>' . $data['title'] . '</b><br>' . get_the_excerpt() . '</flexi_figcaption>'; ?>
      </a>

      <div id="flexi_title" class="flexi_caption_2">
      <h3><?php echo $data['title']; ?></h3>
      <p><?php echo get_the_excerpt(); ?></p>
      </div>

</div>

</div>


