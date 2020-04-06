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

    ?>
       <div class="pure-g">
         <div class="pure-u-1-1" style='text-align: center;'>


         <div class="flexi_margin-box" style="text-align: center;">
                <div class="flexi-image-wrapper_large"><img id="flexi_large_image" src="<?php echo flexi_image_src('flexi-large', $post); ?>"></div>
      </div>


         </div>
         <div class="pure-u-1">
             <div class="flexi_margin-box">
                 <div id="flexi_thumb_image"> <?php flexi_standalone_gallery($id, 'thumbnail', 75, 75);?></div>
             </div>
         </div>
     </div>
<?php

   } else {
    echo '<div id="flexi_no_record" class="flexi_alert-box flexi_error">' . __('Wrong ID', 'flexi') . '</div>';
   }

  }
  $put = ob_get_clean();
  return $put;
 }

}
$standalone = new Flexi_Standalone_Gallery();
