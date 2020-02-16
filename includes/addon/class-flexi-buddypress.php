<?php
class Flexi_Addon_BuddyPress
{
 public function __construct()
 {

  add_filter('flexi_settings_sections', array($this, 'add_section'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));
  add_action('bp_setup_nav', array($this, 'add_flexi_buddypress_tab'));

  add_filter('flexi_settings_fields', array($this, 'add_extension'));
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
  $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $sections = array(
    array(
     'id'          => 'flexi_buddypress_settings',
     'title'       => __('BuddyPress', 'flexi'),
     'description' => __('If you have installed BuddyPress plugin, user can see own submitted images at their profile page. https://wordpress.org/plugins/buddypress/', 'flexi'),
     'tab'         => 'gallery',
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
    'name'              => 'enable_buddypress',
    'label'             => __('Enable BuddyPress', 'flexi'),
    'description'       => __('Displays tab on user profile page of BuddyPress members page.', 'flexi') . ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=gallery&section=flexi_buddypress_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
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
  $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $fields = array('flexi_buddypress_settings' => array(

    array(
     'name'              => 'buddypress_tab_name',
     'label'             => __('Tab name', 'flexi'),
     'description'       => __('Name of the tab displays on profile page', 'flexi'),
     'type'              => 'text',
     'size'              => 'medium',
     'sanitize_callback' => 'sanitize_text_field',
    ),
    array(
     'name'              => 'buddypress_tab_icon',
     'label'             => __('Tab icon', 'flexi'),
     'description'       => __('Ultimate Member\'s icons to be used at profile page. Eg. um-faicon-picture-o', 'flexi'),
     'type'              => 'text',
     'size'              => 'medium',
     'sanitize_callback' => 'sanitize_key',
    ),
   ),
   );
   $new = array_merge($new, $fields);
  }
  return $new;
 }
 public function add_flexi_buddypress_tab($tabs)
 {
  $enable_addon = flexi_get_option('enable_buddypress', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   global $bp;

   $yourtab = flexi_get_option('buddypress_tab_name', 'flexi_buddypress_settings', 'Gallery');

   bp_core_new_nav_item(array(
    'name'                => $yourtab,
    'slug'                => 'flexi',
    'screen_function'     => array($this, 'flexi_buddypress_yourtab_screen'),
    'position'            => 40,
    'parent_url'          => $bp->displayed_user->domain,
    'parent_slug'         => $bp->profile->slug,
    'default_subnav_slug' => 'flexi',
   ));
  }
 }

 public function flexi_buddypress_yourtab_screen()
 {

  // Add title and content here - last is to call the members plugin.php template.

  add_action('bp_template_title', array($this, 'flexi_buddypress_yourtab_title'));
  add_action('bp_template_content', array($this, 'flexi_buddypress_yourtab_content'));
  bp_core_load_template('buddypress/members/single/plugins');
 }
 public function flexi_buddypress_yourtab_title()
 {

  //echo flexi_get_option('buddypress_tab_name', 'flexi_buddypress_settings', 'Gallery');

 }

 public function flexi_buddypress_yourtab_content()
 {

  $user_info = bp_get_displayed_user_username();
  echo do_shortcode('[flexi-gallery user="' . $user_info . '" ] ');

 }

}

//Ultimate Member: Setting at Flexi & Tab at profile page
$buddypress = new Flexi_Addon_BuddyPress();
