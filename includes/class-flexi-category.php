<?php
// Manage categories backend & frontend
class Flexi_Category
{
 public function __construct()
 {
  $taxonomy = 'flexi_category';
  add_filter("manage_edit-" . $taxonomy . "_columns", array($this, 'new_column_category'));
  add_action('manage_' . $taxonomy . '_custom_column', array($this, 'manage_category_columns'), 10, 3);

  $taxonomy_tag = 'flexi_tag';
  add_filter("manage_edit-" . $taxonomy_tag . "_columns", array($this, 'new_column_tag'));
  add_action('manage_' . $taxonomy_tag . '_custom_column', array($this, 'manage_tag_columns'), 10, 3);

  add_action('template_redirect', array($this, 'category_rewrite_view_link'));
 }
 public function new_column_category($columns)
 {

  $columns = array(
   'cb'        => '<input type="checkbox" />',
   'name'      => __('Name'),
   'shortcode' => __('Shortcode'),
   'slug'      => __('Slug'),
   'posts'     => __('Posts'),
  );

  return $columns;

 }
 public function manage_category_columns($out, $column_name, $cat_id)
 {
  $taxonomy = 'flexi_category';

  switch ($column_name) {
   case 'shortcode':
    $a = get_term_by('id', $cat_id, $taxonomy);
    echo '<code>[flexi-gallery album="' . $a->slug . '"]</code>';
    break;

   default:
    break;
  }
 }

 public function new_column_tag($columns)
 {

  $columns = array(
   'cb'        => '<input type="checkbox" />',
   'name'      => __('Name'),
   'shortcode' => __('Shortcode'),
   'slug'      => __('Slug'),
   'posts'     => __('Posts'),
  );

  return $columns;

 }
 public function manage_tag_columns($out, $column_name, $cat_id)
 {
  $taxonomy = 'flexi_tag';

  switch ($column_name) {
   case 'shortcode':
    $a = get_term_by('id', $cat_id, $taxonomy);
    echo '<code>[flexi-gallery tag="' . $a->slug . '"]</code>';
    break;

   default:
    break;
  }
 }

 //Redirect to category page with view is clicked at category & tag of admin dashboard
 public function category_rewrite_view_link()
 {

  $redirect_url = '';
  if (!is_feed()) {
   if (is_tax('flexi_category')) {

    $term         = get_queried_object();
    $redirect_url = flexi_get_category_page_link($term, 'flexi_category');

   }

   if (is_tax('flexi_tag')) {

    $term         = get_queried_object();
    $redirect_url = flexi_get_category_page_link($term, 'flexi_tag');

   }
  }

  // Redirect
  if (!empty($redirect_url)) {

   wp_redirect($redirect_url);
   exit();
  }

 }

}
//Execute
$category = new Flexi_Category();
