<?php
//Check if current page equals to selected page
function is_flexi_page($field_name, $section_name)
{
 //$current_page_id = get_the_ID();
 $current_page_id = get_queried_object_id();
 $test_page_id    = flexi_get_option($field_name, $section_name, 0);

 if ($current_page_id == $test_page_id) {
  return true;
 }
 return false;
}

//Check If Flexi-PRO
function is_flexi_pro()
{
 include_once ABSPATH . 'wp-admin/includes/plugin.php';
 if (is_plugin_active('wp-upg-pro/wp-upg-pro.php')) {
  return true;
 } else {
  return false;
 }
}
