<?php
//User dashboard

class Flexi_User_Dashboard
{
 public function __construct()
 {
  add_shortcode('flexi-user-dashboard', array($this, 'flexi_user_dashboard'));
  add_filter("flexi_submit_toolbar", array($this, 'flexi_add_icon_submit_toolbar'), 10, 2);
 }

 public function flexi_user_dashboard()
 {
  ob_start();
  if (is_singular()) {
   if (is_user_logged_in()) {

    $current_user = wp_get_current_user();
    ?>
    <div style="text-align:center;"><?php echo flexi_author(); ?></div>

   <form method="get">
<div class="ui fluid action input">

<input type="text" name="search" placeholder="<?php echo __('Search post', 'flexi'); ?>">

  <div class="ui button">Search</div>

</div>
</form>

   <div class="ui top attached tabular menu">
  <div class="active item"> <?php echo __('My Posts', 'flexi'); ?></div>
</div>
<div class="ui bottom attached active tab segment">
<?php do_action('flexi_user_dashboard');?>
</div>

<?php

   } else {
    echo flexi_login_link();
   }
  }
  return ob_get_clean();
 }

 //Add My-Dashboard button after form submit
 public function flexi_add_icon_submit_toolbar($icon, $id = '')
 {

  $extra_icon = array();

  $link = flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings');

  if ("#" != $link) {
   $extra_icon = array(
    array("bars", __('My Dashboard', 'flexi'), $link, $id, ''),

   );
  }

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

}
$user_dashboard = new Flexi_User_Dashboard();
