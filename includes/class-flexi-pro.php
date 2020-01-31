<?php
class Flexi_pro
{
 public function __construct()
 {
  if (is_flexi_pro()) {
   add_filter('flexi_settings_sections', array($this, 'add_section'));
   add_filter('flexi_settings_fields', array($this, 'add_fields'));
  }
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
  $sections = array(
   array(
    'id'    => 'flexi_captcha_settings',
    'title' => __('Google reCaptcha Settings', 'flexi'),
    'tab'   => 'form',
   ),
  );
  $new = array_merge($new, $sections);
  return $new;
 }

 //Add section fields
 public function add_fields($new)
 {

  $fields = array('flexi_captcha_settings' => array(
   array(
    'name'              => 'enable_captcha',
    'label'             => __('Enable Captcha', 'flexi'),
    'description'       => __('Security code during form submission. https://www.google.com/recaptcha', 'flexi'),
    'type'              => 'checkbox',
    'sanitize_callback' => 'intval',

   ),
   array(
    'name'              => 'captcha_key',
    'label'             => __('Site key', 'flexi'),
    'description'       => __('Google Captcha Site Key.', 'flexi'),
    'type'              => 'text',
    'size'              => 'large',
    'sanitize_callback' => 'sanitize_key',
   ),
   array(
    'name'              => 'captcha_secret',
    'label'             => __('Secret Key', 'flexi'),
    'description'       => __('Google Captcha secret Key', 'flexi'),
    'type'              => 'text',
    'size'              => 'large',
    'sanitize_callback' => 'sanitize_key',
   ),
  ),
  );
  $new = array_merge($new, $fields);
  return $new;
 }
}
