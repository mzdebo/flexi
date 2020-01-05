<?php

/**
 * Settings
 *
 * @link    https://odude.com
 * @since   1.0.0
 *
 * @package Flexi
 */

// Exit if accessed directly
if (!defined('WPINC')) {
 die;
}

/**
 * flexi_Admin_Settings class.
 *
 * @since 1.0.0
 */
class FLEXI_Admin_Settings
{

 /**
  * Settings tabs array.
  *
  * @since  1.0.0
  * @access protected
  * @var    array
  */
 protected $tabs = array();

 /**
  * Settings sections array.
  *
  * @since  1.0.0
  * @access protected
  * @var    array
  */
 protected $sections = array();

 /**
  * Settings fields array
  *
  * @since  1.0.0
  * @access protected
  * @var    array
  */
 protected $fields = array();

 /**
  * Add a settings menu for the plugin.
  *
  * @since 1.0.0
  */
 public function admin_menu()
 {
  add_submenu_page(
   'flexi',
   __('Flexi - Settings', 'flexi'),
   __('Settings', 'flexi'),
   'manage_options',
   'flexi_settings',
   array($this, 'gallery_settings_form')
  );
 }

 /**
  * gallery settings form.
  *
  * @since 1.0.0
  */
 public function gallery_settings_form()
 {
  require FLEXI_PLUGIN_DIR . 'admin/partials/settings.php';
 }

 /**
  * Initiate settings.
  *
  * @since 1.0.0
  */
 public function admin_init()
 {
  $this->tabs     = $this->get_tabs();
  $this->sections = $this->get_sections();
  $this->fields   = $this->get_fields();

  // Initialize settings
  $this->initialize_settings();
 }

 /**
  * Get settings tabs.
  *
  * @since  1.0.0
  * @return array $tabs Setting tabs array.
  */
 public function get_tabs()
 {
  $tabs = array(
   'general' => __('General', 'flexi'),
   'gallery' => __('Gallery', 'flexi'),
   'form'    => __('Form', 'flexi'),
   'detail'  => __('Detail', 'flexi'),
  );

  return apply_filters('flexi_settings_tabs', $tabs);
 }

 /**
  * Get settings sections.
  *
  * @since  1.0.0
  * @return array $sections Setting sections array.
  */
 public function get_sections()
 {
  $sections = array(
   array(
    'id'    => 'flexi_general_settings',
    'title' => __('General Settings', 'flexi'),
    'tab'   => 'general',
   ),
   array(
    'id'    => 'flexi_image_settings',
    'title' => __('Image Settings', 'flexi'),
    'tab'   => 'general',
   ),

   array(
    'id'    => 'flexi_image_layout_settings',
    'title' => __('Gallery Settings', 'flexi'),
    'tab'   => 'gallery',
   ),

   array(
    'id'    => 'flexi_form_settings',
    'title' => __('Submission Form Settings', 'flexi'),
    'tab'   => 'form',
   ),
   array(
    'id'    => 'flexi_categories_settings',
    'title' => __('Category Settings', 'flexi'),
    'tab'   => 'form',
   ),

   array(
    'id'          => 'flexi_detail_settings',
    'title'       => __('Detail Page Settings', 'flexi'),
    'description' => __('Detail & Popup page displays full content.', 'flexi'),
    'tab'         => 'detail',
   ),
   array(
    'id'          => 'flexi_permalink_settings',
    'title'       => __('Permalink URL Slugs', 'flexi'),
    'description' => __('NOTE: Just make sure that, after updating the fields in this section, you flush the rewrite rules by visiting "Settings > Permalinks". Otherwise you\'ll still see the old links.', 'flexi'),
    'tab'         => 'detail',
   ),

  );

  return apply_filters('flexi_settings_sections', $sections);
 }

 /**
  * Get settings fields.
  *
  * @since  1.0.0
  * @return array $fields Setting fields array.
  */
 public function get_fields()
 {

  $fields = array(
   'flexi_general_settings'      => array(
    array(
     'name'              => 'my_login',
     'label'             => __('Select Login Page', 'flexi'),
     'description'       => __('Login page where user enters username & passwords.', 'flexi'),
     'type'              => 'pages',
     'sanitize_callback' => 'sanitize_key',
    ),

   ),

   'flexi_image_layout_settings' => array(
    array(
     'name'              => 'main_page',
     'label'             => __('Main Gallery Page', 'flexi'),
     'description'       => __('Page with shortcode [flexi-gallery]', 'flexi'),
     'type'              => 'pages',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'my_gallery',
     'label'             => __('Member "My Gallery" Page', 'flexi'),
     'description'       => __('Page with shortcode [flexi-gallery user="show_mine"]. Display gallery of own posts.', 'flexi'),
     'type'              => 'pages',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'perpage',
     'label'             => __('Post per page', 'flexi'),
     'description'       => __('Number of images/post/videos to be shown at a time.', 'flexi'),
     'type'              => 'number',
     'min'               => '1',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'perrow',
     'label'             => __('Number of Columns', 'flexi'),
     'description'       => __('Maximum number of post to be shown horizontally. May automatically change based on screen size.', 'flexi'),
     'type'              => 'number',
     'min'               => '1',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'navigation',
     'label'             => __('Navigation Style', 'flexi'),
     'description'       => '',
     'type'              => 'radio',
     'options'           => array(
      'pagenavi' => __('Page Number', 'flexi'),
      'button'   => __('Load More Button', 'flexi'),
      'scroll'   => __(' Mouse Scroll', 'flexi'),
     ),
     'sanitize_callback' => 'sanitize_key',
    ),

   ),
   'flexi_form_settings'         => array(
    array(
     'name'              => 'publish',
     'label'             => __('Auto approve post', 'flexi'),
     'description'       => __('Automatically publish Post as soon as user submit.', 'flexi'),
     'type'              => 'checkbox',
     'sanitize_callback' => 'intval',
    ),
    array(
     'name'              => 'default_user',
     'label'             => __('Assign default user', 'flexi'),
     'description'       => __('Type the username to assign for guest submit else no author is assigned.', 'flexi'),
     'type'              => 'text',
     'size'              => '20',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'post_image_page',
     'label'             => __('Submission form', 'flexi'),
     'description'       => __('Page which will be used at frontend to let users to submit images.', 'flexi'),
     'type'              => 'pages',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'post_embed_page',
     'label'             => __('Submission form for video URL', 'flexi'),
     'description'       => __('Frontend page to submit YouTube, Vimeo, DailyMotions & more 30+ video urls.', 'flexi'),
     'type'              => 'pages',
     'sanitize_callback' => 'sanitize_key',
    ),

    array(
     'name'              => 'edit_flexi_page',
     'label'             => __('Edit Flexi Post Page', 'flexi'),
     'description'       => __('Page with shortcode [flexi-edit]. Lets visitor to edit submitted post.', 'flexi'),
     'type'              => 'pages',
     'sanitize_callback' => 'sanitize_key',
    ),

   ),
   'flexi_detail_settings'       => array(
    array(
     'name'              => 'lightbox_switch',
     'label'             => __('Enable Lightbox or Popup', 'flexi'),
     'description'       => __('If popup is unchecked, It will open content in single dedicated page.', 'flexi'),
     'type'              => 'checkbox',
     'sanitize_callback' => 'intval',
    ),

   ),
   'flexi_categories_settings'   => array(
    array(
     'name'              => 'global_album',
     'label'             => __('Default Post Category', 'flexi'),
     'description'       => __('This category will be selected if no category is assigned by visitor.', 'flexi'),
     'type'              => 'category',
     'sanitize_callback' => 'sanitize_key',
    ),
   ),

   'flexi_image_settings'        => array(

   ),
   'flexi_page_settings'         => array(

   ),
   'flexi_permalink_settings'    => array(
    array(
     'name'              => 'slug',
     'label'             => __('Image Detail Page', 'flexi'),
     'description'       => __('Replaces the SLUG value used by custom post type "flexi".', 'flexi'),
     'type'              => 'text',
     'sanitize_callback' => 'sanitize_text_field',
    ),
   ),

  );

  return apply_filters('flexi_settings_fields', $fields);
 }

 /**
  * Initialize and registers the settings sections and fields to WordPress.
  *
  * @since 1.0.0
  */
 public function initialize_settings()
 {
  // Register settings sections & fields
  foreach ($this->sections as $section) {
   $page_hook = $section['id'];

   // Sections
   if (false == get_option($section['id'])) {
    add_option($section['id']);
   }

   if (isset($section['description']) && !empty($section['description'])) {
    $callback = array($this, 'settings_section_callback');
   } elseif (isset($section['callback'])) {
    $callback = $section['callback'];
   } else {
    $callback = null;
   }

   add_settings_section($section['id'], $section['title'], $callback, $page_hook);

   // Fields
   $fields = $this->fields[$section['id']];

   foreach ($fields as $option) {
    $name     = $option['name'];
    $type     = isset($option['type']) ? $option['type'] : 'text';
    $label    = isset($option['label']) ? $option['label'] : '';
    $callback = isset($option['callback']) ? $option['callback'] : array($this, 'callback_' . $type);
    $args     = array(
     'id'                => $name,
     'class'             => isset($option['class']) ? $option['class'] : $name,
     'label_for'         => "{$section['id']}[{$name}]",
     'description'       => isset($option['description']) ? $option['description'] : '',
     'name'              => $label,
     'section'           => $section['id'],
     'size'              => isset($option['size']) ? $option['size'] : null,
     'options'           => isset($option['options']) ? $option['options'] : '',
     'sanitize_callback' => isset($option['sanitize_callback']) ? $option['sanitize_callback'] : '',
     'type'              => $type,
     'placeholder'       => isset($option['placeholder']) ? $option['placeholder'] : '',
     'min'               => isset($option['min']) ? $option['min'] : '',
     'max'               => isset($option['max']) ? $option['max'] : '',
     'step'              => isset($option['step']) ? $option['step'] : '',
    );

    add_settings_field("{$section['id']}[{$name}]", $label, $callback, $page_hook, $section['id'], $args);
   }

   // Creates our settings in the options table
   register_setting($page_hook, $section['id'], array($this, 'sanitize_options'));
  }
 }

 /**
  * gallerys a section description.
  *
  * @since 1.0.0
  * @param array $args Settings section args.
  */
 public function settings_section_callback($args)
 {
  foreach ($this->sections as $section) {
   if ($section['id'] == $args['id']) {
    printf('<div class="inside">%s</div>', sanitize_text_field($section['description']));
    break;
   }
  }
 }

 /**
  * gallerys a text field for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_text($args)
 {
  $value       = esc_attr($this->get_option($args['id'], $args['section'], ''));
  $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
  $type        = isset($args['type']) ? $args['type'] : 'text';
  $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';

  $html = sprintf('<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder);
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys a url field for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_url($args)
 {
  $this->callback_text($args);
 }

 /**
  * gallerys a number field for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_number($args)
 {
  $value       = esc_attr($this->get_option($args['id'], $args['section'], 0));
  $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
  $type        = isset($args['type']) ? $args['type'] : 'number';
  $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';
  $min         = empty($args['min']) ? '' : ' min="' . $args['min'] . '"';
  $max         = empty($args['max']) ? '' : ' max="' . $args['max'] . '"';
  $step        = empty($args['max']) ? '' : ' step="' . $args['step'] . '"';

  $html = sprintf('<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step);
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys a checkbox for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_checkbox($args)
 {
  $value = esc_attr($this->get_option($args['id'], $args['section'], 0));

  $html = '<fieldset>';
  $html .= sprintf('<label for="%1$s[%2$s]">', $args['section'], $args['id']);
  $html .= sprintf('<input type="hidden" name="%1$s[%2$s]" value="0" />', $args['section'], $args['id']);
  $html .= sprintf('<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="1" %3$s />', $args['section'], $args['id'], checked($value, 1, false));
  $html .= sprintf('%1$s</label>', $args['description']);
  $html .= '</fieldset>';

  echo $html;
 }

 /**
  * gallerys a multicheckbox for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_multicheck($args)
 {
  $value = $this->get_option($args['id'], $args['section'], array());

  $html = '<fieldset>';
  $html .= sprintf('<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id']);
  foreach ($args['options'] as $key => $label) {
   $checked = in_array($key, $value) ? 'checked="checked"' : '';
   $html .= sprintf('<label for="%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key);
   $html .= sprintf('<input type="checkbox" class="checkbox" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, $checked);
   $html .= sprintf('%1$s</label><br>', $label);
  }
  $html .= $this->get_field_description($args);
  $html .= '</fieldset>';

  echo $html;
 }

 /**
  * gallerys a radio button for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_radio($args)
 {
  $value = $this->get_option($args['id'], $args['section'], '');

  $html = '<fieldset>';
  foreach ($args['options'] as $key => $label) {
   $html .= sprintf('<label for="%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key);
   $html .= sprintf('<input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked($value, $key, false));
   $html .= sprintf('%1$s</label><br>', $label);
  }
  $html .= $this->get_field_description($args);
  $html .= '</fieldset>';

  echo $html;
 }

 /**
  * gallerys a selectbox for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_select($args)
 {
  $value = esc_attr($this->get_option($args['id'], $args['section'], ''));
  $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

  $html = sprintf('<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id']);
  foreach ($args['options'] as $key => $label) {
   $html .= sprintf('<option value="%s"%s>%s</option>', $key, selected($value, $key, false), $label);
  }
  $html .= sprintf('</select>');
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys a textarea for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_textarea($args)
 {
  $value       = esc_textarea($this->get_option($args['id'], $args['section'], ''));
  $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
  $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';

  $html = sprintf('<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $size, $args['section'], $args['id'], $placeholder, $value);
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys the html for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_html($args)
 {
  echo $this->get_field_description($args);
 }

 /**
  * gallerys a rich text textarea for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_wysiwyg($args)
 {
  $value = $this->get_option($args['id'], $args['section'], '');
  $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : '500px';

  echo '<div style="max-width: ' . $size . ';">';
  $editor_settings = array(
   'teeny'         => true,
   'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
   'textarea_rows' => 10,
  );
  if (isset($args['options']) && is_array($args['options'])) {
   $editor_settings = array_merge($editor_settings, $args['options']);
  }
  wp_editor($value, $args['section'] . '-' . $args['id'], $editor_settings);
  echo '</div>';
  echo $this->get_field_description($args);
 }

 /**
  * gallerys a file upload field for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_file($args)
 {
  $value = esc_attr($this->get_option($args['id'], $args['section'], ''));
  $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
  $id    = $args['section'] . '[' . $args['id'] . ']';
  $label = isset($args['options']['button_label']) ? $args['options']['button_label'] : __('Choose File', 'flexi');

  $html = sprintf('<input type="text" class="%1$s-text flexi-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value);
  $html .= '<input type="button" class="button flexi-browse" value="' . $label . '" />';
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys a password field for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_password($args)
 {
  $value = esc_attr($this->get_option($args['id'], $args['section'], ''));
  $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

  $html = sprintf('<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value);
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys a color picker field for a settings field.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_color($args)
 {
  $value = esc_attr($this->get_option($args['id'], $args['section'], '#ffffff'));
  $size  = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

  $html = sprintf('<input type="text" class="%1$s-text flexi-color-picker" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, '#ffffff');
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * gallerys a select box for creating the pages select box.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_pages($args)
 {
  $dropdown_args = array(
   'show_option_none'  => '-- ' . __('Select a page', 'flexi') . ' --',
   'option_none_value' => -1,
   'selected'          => esc_attr($this->get_option($args['id'], $args['section'], -1)),
   'name'              => $args['section'] . '[' . $args['id'] . ']',
   'id'                => $args['section'] . '[' . $args['id'] . ']',
   'echo'              => 0,
  );

  $html = wp_dropdown_pages($dropdown_args);
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * List categories
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function callback_category($args)
 {
  $dropdown_args = array(
   'show_option_none'  => '-- ' . __('Select category', 'flexi') . ' --',
   'option_none_value' => -1,
   'selected'          => esc_attr($this->get_option($args['id'], $args['section'], -1)),
   'name'              => $args['section'] . '[' . $args['id'] . ']',
   'id'                => $args['section'] . '[' . $args['id'] . ']',
   'echo'              => 0,
   'show_count'        => 1,
   'hierarchical'      => 1,
   'taxonomy'          => 'flexi_category',
   'value_field'       => 'slug',
   'hide_empty'        => 0,

  );

  $html = wp_dropdown_categories($dropdown_args);
  $html .= $this->get_field_description($args);

  echo $html;
 }

 /**
  * Get field description for gallery.
  *
  * @since 1.0.0
  * @param array $args Settings field args.
  */
 public function get_field_description($args)
 {
  if (!empty($args['description'])) {
   if ('wysiwyg' == $args['type']) {
    $description = sprintf('<pre>%s</pre>', $args['description']);
   } else {
    $description = sprintf('<p class="description">%s</p>', $args['description']);
   }
  } else {
   $description = '';
  }

  return $description;
 }

 /**
  * Sanitize callback for Settings API.
  *
  * @since  1.0.0
  * @param  array $options The unsanitized collection of options.
  * @return                The collection of sanitized values.
  */
 public function sanitize_options($options)
 {
  if (!$options) {
   return $options;
  }

  foreach ($options as $option_slug => $option_value) {
   $sanitize_callback = $this->get_sanitize_callback($option_slug);

   // If callback is set, call it
   if ($sanitize_callback) {
    $options[$option_slug] = call_user_func($sanitize_callback, $option_value);
    continue;
   }
  }

  return $options;
 }

 /**
  * Get sanitization callback for given option slug.
  *
  * @since  1.0.0
  * @param  string $slug Option slug.
  * @return mixed        String or bool false.
  */
 public function get_sanitize_callback($slug = '')
 {
  if (empty($slug)) {
   return false;
  }

  // Iterate over registered fields and see if we can find proper callback
  foreach ($this->fields as $section => $options) {
   foreach ($options as $option) {
    if ($option['name'] != $slug) {
     continue;
    }

    // Return the callback name
    return isset($option['sanitize_callback']) && is_callable($option['sanitize_callback']) ? $option['sanitize_callback'] : false;
   }
  }

  return false;
 }

 /**
  * Get the value of a settings field.
  *
  * @since  1.0.0
  * @param  string $option  Settings field name.
  * @param  string $section The section name this field belongs to.
  * @param  string $default Default text if it's not found.
  * @return string
  */
 public function get_option($option, $section, $default = '')
 {
  $options = get_option($section);

  if (!empty($options[$option])) {
   return $options[$option];
  }

  return $default;
 }
}
