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
 //echo $shortcode;
 if (defined('REST_REQUEST') && REST_REQUEST) {
  echo "<div style='clear:both;border: 1px solid #999;  font-size: 10px;background: #eee'>";
  echo "<b>Above preview is just for reference.<br>Some settings may not work on specific layout.<br>Below is the shortcode generated for this page<b><hr>";
  echo '<code>' . $shortcode . '</code></div>';

  ?>
  <link rel='stylesheet' id='flexi_public_layout'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/partials/layout/gallery/<?php echo $args['layout']; ?>/style.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_public_css-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/flexi-public.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_fancybox-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/jquery.fancybox.min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_base-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/base-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_grids-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/grids-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_responsive-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/grids-responsive-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_buttons-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/buttons-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_forms-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/forms-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
   <?php

 }

 return ob_get_clean();

}
