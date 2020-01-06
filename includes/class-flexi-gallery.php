<?php
//[flexi-gallery] shortcode
class Flexi_Shortcode_Gallery
{
 public function __construct()
 {

  add_shortcode('flexi-gallery', array($this, 'flexi_gallery'));
  $query_arg = array();
  $aa        = "..";
 }

 public function flexi_gallery($params)
 {
  global $post;
  global $wp_query;

  //Album
  //Get redirected sub album
  $term_slug  = get_query_var('flexi_category');
  $term       = get_term_by('slug', $term_slug, 'flexi_category');
  $album_name = "";
  $album      = "";

  if ("" != $term_slug) {
   //album mentioned in url
   $album = $term_slug;

  } else if (isset($params['album'])) {
   //album at shortcode parameter
   $album = trim($params['album']);
  } else {
   $album = '';

  }

  //Tags
  if (isset($params['tag_show'])) {
   $show_tag = $params['tag_show'];
  }

  //Keyword
  $keyword = '';

  //Page Navigation
  $paged        = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $postsperpage = flexi_get_option('perpage', 'flexi_image_layout_settings', 10);
  $perrow       = flexi_get_option('perrow', 'flexi_image_layout_settings', 3);
  if (isset($params['perpage']) && $params['perpage'] > 0) {
   $postsperpage = $params['perpage'];
  }

  if (isset($params['perrow']) && $params['perrow'] > 0) {
   $perrow = $params['perrow'];
  }

  if (isset($params['page'])) {
   $page = $params['page'];
  }

  //Search
  if (isset($_GET['search'])) {
   $search = $_GET['search'];
  } else {
   $search = "";
  }

  //Order or sorting
  $orderby = '';
  if (isset($params['orderby'])) {
   $orderby = $params['orderby'];
  }

  //Author
  if (isset($params['user'])) {
   $user = $params['user'];
  } else {
   $user = "";
  }

  //Publish Status
  $post_status = array('publish');

  if ("show_mine" == $user) {
   if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user         = $current_user->user_login;
    $post_status  = array('draft', 'publish');
   }

  }

  //Popup
  if (isset($params['popup'])) {
   $popup = $params['popup'];
  } else {
   $popup = flexi_get_option('lightbox_switch', 'flexi_detail_settings', 1);
  }

  //Layout
  if (isset($params['layout'])) {
   $layout = trim($params['layout']);
  } else {
   $layout = 'masonry';
  }

  if ("" != $album && "" != $keyword) {
   $relation = "AND";
  } else {
   $relation = "OR";
  }

  if ("" != $album || "" != $keyword) {
   $args = array(
    'post_type'      => 'flexi',
    'paged'          => $paged,
    's'              => $search,
    'posts_per_page' => $postsperpage,
    'orderby'        => $orderby,
    'order'          => 'DESC',
    'author_name'    => $user,
    'tax_query'      => array(
     'relation' => $relation,
     array(
      'taxonomy' => 'flexi_category',
      'field'    => 'slug',
      'terms'    => explode(',', $album),
      //'terms'    => array( 'mobile', 'sports' ),
      //'include_children' => 0 //It will not include post of sub categories
     ),

     array(
      'taxonomy' => 'flexi_tag',
      'field'    => 'slug',
      'terms'    => explode(',', $keyword),
      //'terms'    => array( 'mobile', 'sports' ),
     ),

    ),
   );
  } else {
   $args = array(
    'post_type'      => 'flexi',
    's'              => $search,
    'paged'          => $paged,
    'posts_per_page' => $postsperpage,
    'author_name'    => $user,
    'post_status'    => $post_status,
    'orderby'        => $orderby,
    'order'          => 'DESC',

   );
  }

  //var_dump($args);

  //Empty array if not logged in
  if (!is_user_logged_in() & isset($params['user']) && "show_mine" == $params['user']) {
   flexi_login_link();

   $args = array();
  }

  if (!empty($args)) {

   $query = new WP_Query($args);
   $count = 0;
   $put   = "";
   ob_start();
   require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/attach_header.php';
   while ($query->have_posts()): $query->the_post();
    require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/attach_loop.php';
    $count++;
   endwhile;
   require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/attach_footer.php';
   $put = ob_get_clean();
   wp_reset_query();

   return $put;
  }
 }

}
