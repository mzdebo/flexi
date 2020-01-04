<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Flexi
 * @subpackage Flexi/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Flexi
 * @subpackage Flexi/public
 * @author     ODude <navneet@odude.com>
 */
class Flexi_Public
{

 /**
  * The ID of this plugin.
  *
  * @since    1.0.0
  * @access   private
  * @var      string    $plugin_name    The ID of this plugin.
  */
 private $plugin_name;

 /**
  * The version of this plugin.
  *
  * @since    1.0.0
  * @access   private
  * @var      string    $version    The current version of this plugin.
  */
 private $version;

 /**
  * Initialize the class and set its properties.
  *
  * @since    1.0.0
  * @param      string    $plugin_name       The name of the plugin.
  * @param      string    $version    The version of this plugin.
  */
 public function __construct($plugin_name, $version)
 {

  $this->plugin_name = $plugin_name;
  $this->version     = $version;
 }

 /**
  * Register the stylesheets for the public-facing side of the site.
  *
  * @since    1.0.0
  */
 public function enqueue_styles()
 {

  /**
   * This function is provided for demonstration purposes only.
   *
   * An instance of this class should be passed to the run() function
   * defined in Flexi_Loader as all of the hooks are defined
   * in that particular class.
   *
   * The Flexi_Loader will then create the relationship
   * between the defined hooks and the functions defined in this
   * class.
   */

  wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/flexi-public.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name . '_fancybox', plugin_dir_url(__FILE__) . 'css/jquery.fancybox.min.css', array(), $this->version, 'all');

 }

 /**
  * Register the JavaScript for the public-facing side of the site.
  *
  * @since    1.0.0
  */
 public function enqueue_scripts()
 {

  /**
   * This function is provided for demonstration purposes only.
   *
   * An instance of this class should be passed to the run() function
   * defined in Flexi_Loader as all of the hooks are defined
   * in that particular class.
   *
   * The Flexi_Loader will then create the relationship
   * between the defined hooks and the functions defined in this
   * class.
   */

  wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/flexi-public.js', array('jquery'), $this->version, false);
  wp_enqueue_script($this->plugin_name . '_fancybox', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.min.js', array('jquery'), $this->version, false);
  wp_enqueue_script($this->plugin_name . '_tags', plugin_dir_url(__FILE__) . '/js/jquery.tagsinput.js', '', $this->version, false);

  //If basic page navigation
  $navigation = flexi_get_option('navigation', 'flexi_image_layout_settings', 'scroll');
  if ('pagenavi' == $navigation) {
   //Not required for page navi
  } else {
   global $wp_query;
   // Localize the script with new data
   $translation_array = array(
    'delete_string' => __('Are you sure you want to delete?', 'flexi'),
    'ajaxurl'       => admin_url('admin-ajax.php'),
   );

   //If scroll ajax is enabled
   if ('scroll' == $navigation) {
    // register our main script but do not enqueue it yet
    wp_register_script('flexi_load_more', plugin_dir_url(__FILE__) . 'js/flexi_load_more_scroll.js', array('jquery'), $this->version);
   } else {
    // register our main script but do not enqueue it yet
    wp_register_script('flexi_load_more', plugin_dir_url(__FILE__) . 'js/flexi_load_more_button.js', array('jquery'), $this->version);

   }

   wp_localize_script('flexi_load_more', 'myAjax', $translation_array);
   wp_enqueue_script('flexi_load_more');

   //Ajax form submission
   wp_register_script('flexi_ajax_post', plugin_dir_url(__FILE__) . 'js/flexi_ajax_post.js', array('jquery'), $this->version);
   //wp_localize_script('flexi_ajax_post', 'myAjax', $translation_array);
   wp_enqueue_script('flexi_ajax_post');

  }
 }
}
