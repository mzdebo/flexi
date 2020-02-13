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
  if ("" != $term_slug && true == $term) {
   $album_name = $term->name;
  }

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
  if (flexi_get_option('gallery_tags', 'flexi_categories_settings', 1) == 1) {
   $show_tag = true;
  }
  if (isset($params['tag_show'])) {
   if ('off' == $params['tag_show']) {
    $show_tag = false;
   } else {
    $show_tag = true;
   }

  }

  //TAGs Keyword
  //Get tags
  $tag_slug = get_query_var('flexi_tag', "");
  $tag      = get_term_by('slug', $tag_slug, 'flexi_tag');
  $tag_name = "";
  if ("" != $tag_slug && true == $tag) {
   $tag_name = $tag->name;
  }

  if ("" != $tag_slug) {
   $keyword = $tag_slug;
//Check if flexi_tag available in URL
  } else if (isset($params['tag'])) {
//Check if tag is mentioned in shortcode
   $keyword = trim($params['tag']);
  } else {
   $keyword = '';
   //Blank keyword if not available.
  }

  //Page Navigation
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

  if (isset($params['perpage']) && $params['perpage'] > 0) {
   $postsperpage = $params['perpage'];
  } else {
   $postsperpage = flexi_get_option('perpage', 'flexi_image_layout_settings', 10);
  }

  if (isset($params['column']) && $params['column'] > 0) {
   $column = $params['column'];
  } else {
   $column = flexi_get_option('column', 'flexi_image_layout_settings', 3);
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
  $username = get_query_var('flexi_user', "");
  if ("" != $username) {
   $user = $username;
  } else if (isset($params['user'])) {
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

  //padding
  if (isset($params['padding'])) {
   $padding = $params['padding'] . 'px';
  } else {
   $padding = flexi_get_option('image_space', 'flexi_gallery_appearance_settings', 0) . 'px';
  }

  //hover_effect
  if (isset($params['hover_effect'])) {
   $hover_effect = $params['hover_effect'];
  } else {
   $hover_effect = flexi_get_option('hover_effect', 'flexi_gallery_appearance_settings', 'flexi_effect_2');
  }

  //hover_effect
  if (isset($params['hover_caption'])) {
   $hover_caption = $params['hover_caption'];
  } else {
   $hover_caption = flexi_get_option('hover_caption', 'flexi_gallery_appearance_settings', 'flexi_caption_4');
  }

  //Layout
  if (isset($params['layout'])) {
   $layout = trim($params['layout']);
  } else {
   $layout = flexi_get_option('gallery_layout', 'flexi_image_layout_settings', 'masonry');
  }

  //Navigation
  if (isset($params['navigation'])) {
   $navigation = trim($params['navigation']);
  } else {
   $navigation = flexi_get_option('navigation', 'flexi_image_layout_settings', 'button');
  }

  if ("" != $album && "" != $keyword) {
   $relation = "AND";
  } else {
   $relation = "OR";
  }

  if ("" != $album || "" != $keyword) {
   $args = array(
    'post_type'      => 'flexi',
    's'              => $search,
    'paged'          => $paged,
    'posts_per_page' => $postsperpage,
    'author_name'    => $user,
    'post_status'    => $post_status,
    'orderby'        => $orderby,
    'order'          => 'DESC',
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
   wp_register_style('flexi_' . $layout . '_layout', plugin_dir_url(__FILE__) . '../public/partials/layout/gallery/' . $layout . '/style.css', null, FLEXI_VERSION);
   wp_enqueue_style('flexi_' . $layout . '_layout');
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

 public function enqueue_styles_head()
 {

  $img_width  = flexi_get_option('t_width', 'flexi_media_settings', 150);
  $img_height = flexi_get_option('t_height', 'flexi_media_settings', 150);
  $padding    = '0';
  $put        = "";
  ob_start();

  ?>
<style>
:root {
  --flexi_t_width: <?php echo $img_width; ?>px;
  --flexi_t_height: <?php echo $img_height; ?>px;
  --flexi_padding: <?php echo $padding; ?>px;
}
</style>

<script>
jQuery(document).ready(function() {
 // console.log("start");
  document.documentElement.style.setProperty('--flexi_padding', jQuery("#padding").text());


  jQuery('[data-fancybox-trigger').fancybox({
        selector : '.flexi_show_popup a:visible',
        thumbs   : {
    autoStart : true
  },
  protect: true,
        caption: function(instance, item) {
          //This is not working on ajax loading. only for for page navigation.
         // return jQuery(this).closest('flexi_media_holder').find('flexi_figcaption').html();
          return jQuery(this).find('flexi_figcaption').html();
         // return jQuery(this).children('flexi_figcaption').html();

        }
    });

});
</script>


    <?php
$put = ob_get_clean();
  echo $put;
 }

}
