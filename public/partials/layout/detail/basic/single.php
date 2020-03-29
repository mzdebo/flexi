<?php
/*
<a href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'>
<?php echo __('Edit Post', 'flexi'); ?>
</a>
 */
?>
<div class="flexi_content" id="flexi_content_<?php echo get_the_ID(); ?>">

  <div class="container">
    <div class="row">
      <div class="col">

        <?php if (get_post_status() == 'draft' || get_post_status() == "pending") {?><Small>
          <div class="flexi_badge"> <?php echo __("Under Review", "flexi"); ?></div>
        </small><?php }?>
        <?php
echo "<div class='flexi_frame_1' ><img src='" . flexi_image_src('flexi-large') . "' ></div>";
?>

      </div>

    </div>
    <div class="row">
      <div class="col">
        <?php echo flexi_show_icon_grid(); ?>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <?php flexi_standalone_gallery(get_the_ID(), 'flexi-thumb');?>
      </div>
    </div>

  </div>

  <?php echo wpautop(stripslashes($post->post_content)); ?>
  <hr>
  <?php echo flexi_custom_field_loop($post, 'detail'); ?>
  <hr>
  <?php flexi_list_album($post, 'ui avatar image');?>
  <hr>
  <?php flexi_list_tags($post, 'ui tag label');?>

</div>