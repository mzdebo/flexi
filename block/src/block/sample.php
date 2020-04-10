<?php
/**
 * Register Gutenberg block on server-side.
 *
 * Register the block on server-side to ensure that the block
 * scripts and styles for both frontend and backend are
 * enqueued when the editor loads.
 *
 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
 * @since 1.16.0
 */
register_block_type(
 'cgb/block-flexi-block', array(
  // Enqueue blocks.style.build.css on both frontend & backend.
  'style'           => 'flexi_block-cgb-style-css',
  // Enqueue blocks.build.js in the editor only.
  'editor_script'   => 'flexi_block-cgb-block-js',
  // Enqueue blocks.editor.build.css in the editor only.
  'editor_style'    => 'flexi_block-cgb-block-editor-css',
  'attributes'      => array(
   'layout'   => array(
    'type'    => 'string',
    'default' => 'regular',
   ),
   'column'   => array(
    'type'    => 'integer',
    'default' => 2,
   ),
   'cat'      => array(
    'type'    => 'integer',
    'default' => 0,
   ),
   'perpage'  => array(
    'type'    => 'integer',
    'default' => 10,
   ),
   'popup'    => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'tag_show' => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'orderby'  => array(
    'type'    => 'string',
    'default' => 'asc',
   ),
   'tag'      => array(
    'type'    => 'string',
    'default' => '',
   ),
  ),
  'render_callback' => 'flexi_gallery_render_callback',
 )
);

function flexi_gallery_render_callback($args)
{

 if (!current_user_can('administrator')) {
  return __('you are not authorized to view this block.', 'flexi');
 }
 // generate the output html
 ob_start();
 $shortcode = '[flexi-gallery]';

/**
 * Use attribute from the block
 */
 if (isset($args['column'])) {

  if (isset($args['popup']) && '1' == $args['popup']) {
   $popup = "on";
  } else {
   $popup = "off";
  }

  if (isset($args['tag_show']) && '1' == $args['tag_show']) {
   $tag_show = "on";
  } else {
   $tag_show = "off";
  }

  $cat = get_term_by('id', $args['cat'], 'flexi_category');
  if ($cat) {
   $cat = $cat->slug;
  } else {
   $cat = "";
  }

  $shortcode = '[flexi-gallery
  column="' . $args['column'] . '"
  perpage="' . $args['perpage'] . '"
  layout="' . $args['layout'] . '"
  popup="' . $popup . '"
  album="' . $cat . '"
  tag="' . $args['tag'] . '"
  orderby="' . $args['orderby'] . '"
  tag_show="' . $tag_show . '"
   ]';
 }
 //print_r($args);

 echo do_shortcode($shortcode);

 if (defined('REST_REQUEST') && REST_REQUEST) {
  echo "<b>Below is the shortcode generated for this page<b><hr>";
  echo '<code>' . $shortcode . '</code>';
 }

 return ob_get_clean();

}
