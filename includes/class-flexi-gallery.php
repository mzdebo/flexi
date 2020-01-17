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
  $show_tag = false;
  if (flexi_get_option('gallery_tags', 'flexi_image_layout_settings', 1) == 1) {
   $show_tag = true;
  }
  if (isset($params['tag_show'])) {
   if ('off' == $params['tag_show']) {
    $show_tag = false;
   } else {
    $show_tag = true;
   }

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

   //Generate tags array
   if ($show_tag) {
    //Get the tags only
    $tags_array = array();
    while ($query->have_posts()): $query->the_post();
     foreach (wp_get_post_terms($post->ID, 'flexi_tag') as $t) {
      $tags_array[$t->slug] = $t->name;
     }
     // this adds to the array in the form ['slug']=>'name'
    endwhile;
    // de-dupe
    $tags_array = array_unique($tags_array);
    natcasesort($tags_array);
    //print_r($tags_array);
   }

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

 public function enqueue_styles()
 {

  $img_width  = flexi_get_option('t_width', 'flexi_media_settings', 150);
  $img_height = flexi_get_option('t_height', 'flexi_media_settings', 150);
  $put        = "";
  ob_start();

  ?>
<style>
.flexi_grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(<?php echo $img_width; ?>px, 1fr));
  grid-gap: 20px;
  align-items: stretch;
  }

.flexi_grid > flexi_article img {
  max-height: <?php echo $img_height; ?>px;
  max-width: 100%;

}

</style>

<script>
jQuery(document).ready(function() {

    jQuery('[data-fancybox]').fancybox({
        caption: function(instance, item) {
            return jQuery(this).find('flexi_figcaption').html();
        }
    });
});
</script>


    <?php
$put = ob_get_clean();
  echo $put;
 }

}
