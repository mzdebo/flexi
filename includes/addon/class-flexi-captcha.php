<?php
class Flexi_Addon_Captcha
{
 public function __construct()
 {

  add_filter('flexi_settings_sections', array($this, 'add_section'));
  add_filter('flexi_settings_fields', array($this, 'add_extension'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));
  add_action('flexi_captcha', array($this, 'flexi_display_captcha_code'), 10, 0);
  add_action('wp_head', array($this, 'enqueue_styles_head'));
  add_filter('flexi_verify_submit', array($this, 'verify_submit_action'));
 }

 //add_filter flexi_settings_tabs
 public function add_tabs($new)
 {
  $tabs = array();
  $new  = array_merge($tabs, $new);
  return $new;
 }

 //Add Section title
 public function add_section($new)
 {
  $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $sections = array(
    array(
     'id'          => 'flexi_captcha_settings',
     'title'       => __('Google reCaptcha v2', 'flexi'),
     'description' => __('Get API information from https://www.google.com/recaptcha. It will ask for security code during form submission if captcha field is added.', 'flexi'),
     'tab'         => 'form',
    ),
   );
   $new = array_merge($new, $sections);
  }
  return $new;
 }

 //Add enable/disable option at extension tab
 public function add_extension($new)
 {
  $fields = array('flexi_extension' => array(
   array(
    'name'              => 'enable_captcha',
    'label'             => __('Enable Captcha', 'flexi'),
    'description'       => __('Security code during form submission. https://www.google.com/recaptcha', 'flexi') . ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_captcha_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
    'type'              => 'checkbox',
    'sanitize_callback' => 'intval',

   ),
  ),
  );
  $new = array_merge_recursive($new, $fields);

  return $new;
 }

 //Add section fields
 public function add_fields($new)
 {
  $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $fields = array('flexi_captcha_settings' => array(

    array(
     'name'              => 'captcha_key',
     'label'             => __('Site key', 'flexi'),
     'description'       => __('Google Captcha Site Key.', 'flexi'),
     'type'              => 'text',
     'size'              => 'large',
     'sanitize_callback' => 'sanitize_text_field',
    ),
    array(
     'name'              => 'captcha_secret',
     'label'             => __('Secret Key', 'flexi'),
     'description'       => __('Google Captcha secret Key', 'flexi'),
     'type'              => 'text',
     'size'              => 'large',
     'sanitize_callback' => 'sanitize_text_field',
    ),
   ),
   );
   $new = array_merge($new, $fields);
  }
  return $new;
 }

 public function flexi_display_captcha_code()
 {
  $title    = __("Security Check", "flexi");
  $site_key = flexi_get_option('captcha_key', 'flexi_captcha_settings', '');
  //$secret_key=flexi_get_option('captcha_secret', 'flexi_captcha_settings', '');
  $captcha      = "";
  $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   ?>
		<label for="captcha"><?php echo $title; ?></label>
<?php
$captcha = '<div class="g-recaptcha" data-sitekey="' . $site_key . '"></div>';
  }

  echo $captcha;
 }

 public function enqueue_styles_head()
 {
  if (!is_admin()) {
   global $post;
   $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
   if ("1" == $enable_addon) {
    if (has_shortcode($post->post_content, 'flexi-form')) {
     ?>
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <?php
}
   }
  }
 }

 public function flexi_verify_captcha()
 {

  $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
  if ("0" == $enable_addon) {
   return "OK";
  }

  if (isset($_POST['g-recaptcha-response'])) {

   $recaptcha_secret = flexi_get_option('captcha_secret', 'flexi_captcha_settings', '');
   $response         = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);

   if (is_array($response) && array_key_exists('body', $response)) {
    $response = json_decode($response["body"], true);
    if (true == $response["success"]) {
     //return true;
     return "OK";
    } else {
     //return false;
     //return "oooo";
     return __("Please complete the security spam check.", "flexi");
    }
   } else {
    return __("Google Server Error", "flexi");
   }
  } else {
   return "OK";
   // return __("Bots are not allowed. If you are not a bot then please enable JavaScript in browser.", "flexi");

  }
 }

 public function verify_submit_action($newPost)
 {

  if ($this->flexi_verify_captcha() == "OK") {
   return "";
  } else {
   return 'invalid-captcha';
  }
 }

}

//Ultimate Member: Setting at Flexi & Tab at profile page
$captcha = new Flexi_Addon_Captcha();
