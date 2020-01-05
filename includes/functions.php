<?php
//Get post button link
function flexi_get_button_url($param = '', $ajax = true, $type = 'post_image_page', $setting_tab = 'flexi_form_settings')
{
 if ($ajax) {
  $url = 'admin-ajax.php?action=flexi_send_again&post_id=' . $param;
 } else {
  $default_post = flexi_get_option($type, $setting_tab, '0');
  if ('0' != $default_post) {
   $url = esc_url(get_page_link($default_post));
  } else {
   $url = "#";
  }

 }
 return $url;

}

//Default reference replaced by settings and attributes
function flexi_default_args($params)
{
 $value = array(
  'class'         => 'pure-form pure-form-stacked',
  'title'         => 'Submit',
  'preview'       => 'default',
  'name'          => '',
  'id'            => get_the_ID(),
  'taxonomy'      => 'flexi_category',
  'tag_taxonomy'  => 'flexi_tag',
  'upload_type'   => 'flexi',
  'ajax'          => 'true',
  'media_private' => 'false',
  '',
 );
 if (isset($_POST['user-submitted-title'])) {
  $value['user-submitted-title'] = sanitize_text_field($_POST['user-submitted-title']);
 } else {
  $value['user-submitted-title'] = '';
 }

 if (isset($_POST['user-submitted-content'])) {
  $content          = flexi_sanitize_content($_POST['user-submitted-content']);
  $content          = str_replace("[", "[[", $content);
  $content          = str_replace("]", "]]", $content);
  $value['content'] = $content;
 } else {
  $value['content'] = "";
 }

 if (isset($_POST['cat'])) {
  $value['category'] = intval($_POST['cat']);
 } else {
  $value['category'] = flexi_get_option('global_album', 'flexi_categories_settings', '');
 }

 if (isset($_POST['tags'])) {
  $value['tags'] = $_POST['tags'];
 } else {
  $value['tags'] = '';
 }

 return shortcode_atts($value, $params);
}

//Submits new post.
//$title = Title of post
//$files = files selected
//$content= Description
//category =Album name
//$preview = layout name for post detail page. Not required if lightbox is enabled.
function flexi_submit($title, $files, $content, $category, $preview, $tags = '')
{
 $post_type    = 'flexi';
 $taxonomy     = 'flexi_category';
 $tag_taxonomy = 'flexi_tag';

 $newPost            = array('id' => false, 'error' => false);
 $newPost['error'][] = "";
 $file_count         = 0;
 if (empty($title)) {
  $newPost['error'][] = 'required-title';
 }

 //if (empty($content))  $newPost['error'][] = 'required-description';

 $newPost['error'][] = apply_filters('flexi_verify_submit', "");

 if (isset($files['tmp_name'][0])) {
  $check_file_exist = $files['tmp_name'][0];
 } else {
  $check_file_exist = "";
 }

 //It will only check file type is image
 if (!empty($check_file_exist)) {
  $file_data  = flexi_check_images($files, $newPost);
  $file_count = $file_data['file_count'];

  //echo "<h1>$file_count</h1>";
  //error_log("File count ".$file_count);

  $newPost['error'] = array_unique(array_merge($file_data['error'], $newPost['error']));
 }

 foreach ($newPost['error'] as $e) {

  if (!empty($e)) {
   //error_log("Error: ".$e);
   unset($newPost['id']);
   return $newPost;
  }
 }

 $postData = flexi_prepare_post($title, $content, $post_type);
 do_action('flexi_insert_before', $postData);
 //Include important files required during upload
 flexi_include_deps();
 $i = 0;
 if (0 == $file_count) {
  //Execute loop at least once
  $file_count = 1;
 }

 for ($x = 1; $x <= $file_count; $x++) {

  $newPost['id'] = wp_insert_post($postData);
  if ($newPost['id']) {
   //echo "Successfully added $x <hr>";
   $post_id = $newPost['id'];

   if ('' != $category) {
    wp_set_object_terms($post_id, array($category), $taxonomy);
   }

   if (taxonomy_exists($tag_taxonomy)) {
    //Set TAGS
    if ('' != $tags) {
     wp_set_object_terms($post_id, explode(",", $tags), $tag_taxonomy);
    }

   }

   //Assign preview layout
   add_post_meta($post_id, 'flexi_layout', $preview);

   $attach_ids = array();
   if ($files && !empty($check_file_exist)) {
    $key = apply_filters('flexi_file_key', 'user-submitted-image-{$i}');

    $_FILES[$key]             = array();
    $_FILES[$key]['name']     = $files['name'][$i];
    $_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
    $_FILES[$key]['type']     = $files['type'][$i];
    $_FILES[$key]['error']    = $files['error'][$i];
    $_FILES[$key]['size']     = $files['size'][$i];

    $attach_id = media_handle_upload($key, $post_id);

    //$my_image_alt = preg_replace( ‘%[^0-9a-z]+%i’, ‘ ‘, $title );
    //$my_image_alt = preg_replace( ‘%[\s]+%’, ‘ ‘, $my_image_alt );
    //update_post_meta( $attach_id, '_wp_attachment_image_alt', $my_image_alt );

    if (!is_wp_error($attach_id) && wp_attachment_is_image($attach_id)) {

     $attach_ids[] = $attach_id;
     add_post_meta($post_id, 'flexi_image_id', $attach_id);
     add_post_meta($post_id, 'flexi_image', flexi_image_src('large', get_post($post_id)));
    } else {
     wp_delete_attachment($attach_id);
     wp_delete_post($post_id, true);
     $newPost['error'][] = 'upload-error';
     unset($newPost['id']);
     return $newPost;
    }
    $i++;
   } else {
    //Checking in setting if image is compulsory during submission.
    /*
   if ('1' == $options['image_required']) {
   $newPost['error'][] = 'no-files';
   }
    */
   }
  } else {
   $newPost['error'][] = 'post-fail';
  }
 }

 do_action('flexi_insert_after', $newPost);
 return $newPost;
}

//During image upload process, it check the file is valid image type.
function flexi_check_images($files)
{
 $temp  = false;
 $errr  = false;
 $error = array();

 if (isset($files['tmp_name'])) {
  $temp = array_filter($files['tmp_name']);
 }

 if (isset($files['error'])) {
  $errr = array_filter($files['error']);
 }

 $file_count = 0;
 if (!empty($temp)) {
  foreach ($temp as $key => $value) {
   if (is_uploaded_file($value)) {
    $file_count++;
   }
  }

 }
 if (true) {

  $i = 0;

  $image = @getimagesize($temp[$i]);

  if (false === $image) {
   $error[] = 'file-type';
   //error_log("Check file size");
   //break;
  } else {
   if (function_exists('exif_imagetype')) {
    if (isset($temp[$i]) && !exif_imagetype($temp[$i])) {
     $error[] = 'exif_imagetype';
     //break;
    }
   }

  }

  //$file = wp_max_upload_size( $temp[$i] );
  // if ( $file['error'] != '0' )
  //{
  // if($temp[$i] < wp_max_upload_size())
  // $error[] = 'max-filesize';
  //}

 } else {
  $files = false;
 }
 $file_data = array('error' => $error, 'file_count' => $file_count);

 //error_log("file count ".$file_count);

 return $file_data;
}

//Sanitize the $content.
function flexi_sanitize_content($content)
{
 $allowed_tags = wp_kses_allowed_html('post');
 return wp_kses(stripslashes($content), $allowed_tags);
}

//Before posting, assigning required metadata to the post.
function flexi_prepare_post($title, $content, $post_type = 'flexi')
{
 $postData                 = array();
 $postData['post_title']   = $title;
 $postData['post_content'] = $content;
 $postData['post_author']  = flexi_get_author();
 $postData['post_type']    = 'flexi';

 //upg_log($content."---".$post_type);

 if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {
  $postData['post_status'] = 'publish';
 }

 return apply_filters('flexi_post_data', $postData);
}

//Including the files used during the time of file upload. It is required to get default wordpress file handling.
function flexi_include_deps()
{
 if (!function_exists('media_handle_upload')) {
  require_once ABSPATH . '/wp-admin/includes/media.php';
  require_once ABSPATH . '/wp-admin/includes/file.php';
  require_once ABSPATH . '/wp-admin/includes/image.php';
 }
}

//Check If Flexi-PRO
function is_flexi_pro()
{
 return false;
}

//Drop down list of albums
function flexi_droplist_album($taxonomy = 'flexi_category', $selected_album = "", $skip = array())
{

 $dropdown_args = array(

  'selected'     => $selected_album,
  'name'         => 'cat',
  'id'           => '',
  'echo'         => 1,
  'show_count'   => 0,
  'hierarchical' => 1,
  'taxonomy'     => $taxonomy,
  'value_field'  => 'term_id',
  'hide_empty'   => 0,
  'exclude'      => $skip,
 );

 wp_dropdown_categories($dropdown_args);

 // var_dump($args);

}

//log_me('This is a message for debugging purposes. works if debug is enabled.');
function flexi_log($message)
{
 if (WP_DEBUG === true) {
  if (is_array($message) || is_object($message)) {
   error_log(print_r($message, true));
  } else {
   error_log($message);
  }
 }
}

//
// All commonly used function are listed
//
//Return image url
function flexi_image_src($size = 'thumbnail', $post = '')
{
 if ('' == $post) {
  global $post;
 }

 //If $post is numeric
 //$post   = get_post($post);

 // $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size);
 $image_attributes = wp_get_attachment_image_src(get_post_meta($post->ID, 'flexi_image_id', 1), $size);
 //flexi_log($image_attributes[0] . "--");
 if ($image_attributes) {
  return $image_attributes[0];
 } else {
  return plugins_url('../public/images/noimg.png', __FILE__);
 }
}

//Returns author ID of logged in user. If not returns the id of default user in UPG settings.
function flexi_get_author()
{
 if (is_user_logged_in()) {
  $author_id = get_current_user_id();
 } else {
  $the_user = get_user_by('login', flexi_get_option('default_user', 'flexi_form_settings', '0'));
  if (!empty($the_user)) {
   $author_id = $the_user->ID;
  } else {
   $author_id = 0;
  }
 }

 return $author_id;
}

//Get link and added attributes of the image based on lightbox
function flexi_image_data($size = 'full', $post = '')
{
 $data              = array();
 $data['title']     = get_the_title();
 $lightbox_settings = get_option('flexi_detail_settings');
 if (empty($lightbox_settings['lightbox_switch'])) {
  $lightbox = false;
 } else {
  $lightbox = true;
 }

 if ('' == $post) {
  global $post;
 }

 if ($lightbox) {
  $data['url']   = flexi_image_src('full', $post);
  $data['extra'] = 'data-fancybox="image"';
 } else {
  $data['url']   = get_permalink();
  $data['extra'] = '';
 }
 return $data;
}
/**
 * Get default plugin settings.
 *
 * @since  1.0.0
 * @return array $defaults Array of plugin settings.
 */
function flexi_get_default_settings()
{

 //Lightbox Enabled
 flexi_set_option('lightbox_switch', 'flexi_detail_settings', 1);
 return;
}

/**
 * Get the value of a settings field
 *
 * @param string $field_name settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function flexi_get_option($field_name, $section = 'flexi_detail_settings', $default = '')
{
 //Example
 //flexi_get_option('field_name', 'setting_name', 'default_value');

 $options = (array) get_option($section);

 if (isset($options[$field_name])) {
  return $options[$field_name];
 } else {
  //Set the default value if not found
  flexi_set_option($field_name, $section, $default);

 }

 return $default;
}

//Set options in settings
function flexi_set_option($field_name, $section = 'flexi_general_settings', $default = '')
{
//Example
 //flexi_set_option('field_name', 'setting_name', 'default_value');
 $options              = (array) get_option($section);
 $options[$field_name] = $default;
 update_option($section, $options);

 return;
}

//Create required pages
function flexi_create_pages()
{
 global $wpdb;
 if (!$wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[flexi-gallery]%'")) {

  $aid = wp_insert_post(array('post_title' => 'Flexi Gallery', 'post_content' => '[flexi-gallery]', 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('main_page', 'flexi_image_layout_settings', $aid);

  $str_post_image = '
		[flexi-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" ajax="true"]
		[flexi-form-tag type="post_title" title="Title" value="" placeholder="main title"]
		[flexi-form-tag type="category" title="Select category" taxonomy="flexi_cate" filter="image"]
		[flexi-form-tag type="tag" title="Insert tag"]
		[flexi-form-tag type="article" title="Description"  placeholder="Content"]
		[flexi-form-tag type="file" title="Select file"]
		[flexi-form-tag type="submit" name="submit" value="Submit Now"]
		[/flexi-form]
		';

  $bid = wp_insert_post(array('post_title' => 'Post Image', 'post_content' => $str_post_image, 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('post_image_page', 'flexi_form_settings', $bid);

  $str_post_embed = '
  [flexi-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" ajax="true" post_type="video_url"]
  [flexi-form-tag type="post_title" title="Video Title" value="" placeholder="main title"]
  [flexi-form-tag type="category" title="Select category" taxonomy="flexi_cate" filter="embed" ]
  [flexi-form-tag type="tag" title="Insert tag"]
  [flexi-form-tag type="article" title="Description"  placeholder="Content"]
  [flexi-form-tag type="video_url" title="Submit public embed URL" placeholder="http://" required="true"]
  [flexi-form-tag type="submit" name="submit" value="Submit URL"]
  [/flexi-form]
  ';

  $cid = wp_insert_post(array('post_title' => 'Post Video URL', 'post_content' => $str_post_embed, 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('post_embed_page', 'flexi_form_settings', $cid);

  $did = wp_insert_post(array('post_title' => 'My Gallery', 'post_content' => '[flexi-gallery user="show_mine"]', 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('my_gallery', 'flexi_image_layout_settings', $did);

  $eid = wp_insert_post(array('post_title' => 'Edit Flexi Post', 'post_content' => '[flexi-edit]', 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('edit_flexi_page', 'flexi_form_settings', $eid);

 }

}
