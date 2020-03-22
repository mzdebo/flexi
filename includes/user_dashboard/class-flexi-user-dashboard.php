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
   do_action('flexi_user_dashboard');
  }
  return ob_get_clean();
 }

}
$user_dashboard = new Flexi_User_Dashboard();
