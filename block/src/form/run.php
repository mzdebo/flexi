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
 'cgb/block-flexi-block-form', array(
  // Enqueue blocks.style.build.css on both frontend & backend.
  'style'           => 'flexi_block-cgb-style-css',
  // Enqueue blocks.build.js in the editor only.
  'editor_script'   => 'flexi_block-cgb-block-js',
  // Enqueue blocks.editor.build.css in the editor only.
  'editor_style'    => 'flexi_block-cgb-block-editor-css',
  'attributes'      => array(
   'enable_ajax' => array(
    'type'    => 'boolean',
    'default' => false,
   ),
   'form_class'  => array(
    'type'    => 'string',
    'default' => 'pure-form pure-form-stacked',
   ),
   'form_title'  => array(
    'type'    => 'string',
    'default' => 'My Form',
   ),
   'label_title' => array(
    'type'    => 'string',
    'default' => 'Title',
   ),
  ),
  'render_callback' => 'flexi_form_render_callback',
 )
);

function flexi_form_render_callback($args)
{

 if (!current_user_can('administrator')) {
  return __('you are not authorized to view this block.', 'flexi');
 }
 // generate the output html
 ob_start();
 $shortcode = '';

/**
 * Use attribute from the block
 */
 if (isset($args['form_class'])) {

  if (isset($args['enable_ajax']) && '1' == $args['enable_ajax']) {
   $enable_ajax = "true";
  } else {
   $enable_ajax = "false";
  }

  $shortcode = '[flexi-form class="' . $args['form_class'] . '" title="' . $args['form_title'] . '" name="my_form" ajax="' . $enable_ajax . '"]';

  $shortcode .= '[flexi-form-tag type="post_title" title="' . $args['label_title'] . '" value="" placeholder="main title"]';

  $shortcode .= '[/flexi-form]';
 }
 //print_r($args);

 echo do_shortcode($shortcode);
 //echo $shortcode;
 if (defined('REST_REQUEST') && REST_REQUEST) {
  echo "<div style='clear:both;border: 1px solid #999; background: #eee'>";
  echo "<ul><li>Preview is for reference and may not view same.
  <li>Below shortcode generated for this page</ul>";
  echo '<code>' . $shortcode . '</code></div>';

  ?>
<link rel='stylesheet' id='flexi_public_css-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/flexi-public.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />

<link rel='stylesheet' id='flexi_purecss_base-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/base-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_grids-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/grids-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_responsive-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/grids-responsive-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_buttons-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/buttons-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
<link rel='stylesheet' id='flexi_purecss_forms-css'  href='<?php echo FLEXI_PLUGIN_URL; ?>/public/css/purecss/forms-min.css?ver=<?php echo FLEXI_VERSION; ?>' media='all' />
   <?php

 }

 return ob_get_clean();

}
