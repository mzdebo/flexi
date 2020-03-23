<?php
//User dashboard

class Flexi_User_Dashboard
{
 public function __construct()
 {
  add_shortcode('flexi-user-dashboard', array($this, 'flexi_user_dashboard'));
 }

 public function flexi_user_dashboard()
 {
  ob_start();
  if (is_singular()) {
   if (is_user_logged_in()) {

    $current_user = wp_get_current_user();
    ?>
   <?php echo __('Welcome') . ' ' . $current_user->display_name . ' !'; ?>

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

}
$user_dashboard = new Flexi_User_Dashboard();
