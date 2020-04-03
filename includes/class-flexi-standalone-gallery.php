<?php
class Flexi_Standalone_Gallery
{
 public function __construct()
 {
  add_shortcode('flexi-standalone', array($this, 'flexi_standalone'));
 }

 public function flexi_standalone($params)
 {
  $put = "";
  ob_start();

  if (isset($params['id'])) {
   $id   = $params['id'];
   $post = get_post($id);

   if ($post) {

//hover_effect
    if (isset($params['hover_effect'])) {
     $hover_effect = $params['hover_effect'];
    } else {
     $hover_effect = flexi_get_option('hover_effect', 'flexi_gallery_appearance_settings', 'flexi_effect_2');
    }

    $files = get_post_meta($post->ID, 'flexi_standalone_gallery', 1);
    // Loop through them and output an image
    if (!empty($files)) {
     foreach ((array) $files as $attachment_id => $attachment_url) {

      $image_alt = flexi_get_attachment($attachment_id);

      echo '<div class="flexi_responsive flexi_gallery_child" ><div class="flexi_gallery_grid flexi_effect image-wrapper" id="' . $hover_effect . '"><div class="flexi-image-wrapper"><div class="flexi-image-wrapper"><a data-fancybox="flexi_standalone_gallery" class="" href="' . wp_get_attachment_image_src($attachment_id, 'flexi_large')[0] . '" data-caption="' . $image_alt['title'] . '" border="0">';
      echo '<img src="' . wp_get_attachment_image_src($attachment_id, 'flexi-medium')[0] . '">';
      echo '</a></div></div></div></div>';

     }
    } else {
     echo '<div id="flexi_no_record" class="flexi_alert-box flexi_warning">' . __('No records', 'flexi') . '</div>';
    }

   } else {
    echo '<div id="flexi_no_record" class="flexi_alert-box flexi_error">' . __('Wrong ID', 'flexi') . '</div>';
   }

  }
  $put = ob_get_clean();
  return $put;
 }

}
$standalone = new Flexi_Standalone_Gallery();
