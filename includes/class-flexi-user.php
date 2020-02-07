<?php
//All related with members & users
class Flexi_User
{
 public function __construct()
 {
  //Add custom query vars
  add_filter('query_vars', array($this, 'add_query_vars_filter'));
 }

 public function add_query_vars_filter($vars)
 {
  $vars[] = "flexi_user";
  return $vars;
 }

 public function flexi_add_user_profile_icon($icon)
 {
  global $post;
  $link   = get_permalink(flexi_get_option('main_page', 'flexi_image_layout_settings', 0));
  $author = get_user_by('id', get_the_author_meta('ID'));
  $link   = add_query_arg("flexi_user", $author->user_nicename, $link);

  $extra_icon = array();

  //if (get_the_author_meta('ID') == get_current_user_id()) {
  // if (isset($options['show_trash_icon'])) {
  // if ("1" == $options['show_trash_icon']) {
  $extra_icon = array(
   array("dashicons-admin-users", 'Profile', $link, 'flexi_user', $post->ID),

  );
  //  }
  // }
  //}
  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }
}
