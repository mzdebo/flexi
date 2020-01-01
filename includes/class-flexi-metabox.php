<?php

/**
 * Register Meta Boxes
 */
class Flexi_Meta_boxes
{

 /**
  * Register CMB2 Meta-boxes
  *
  * @link https://github.com/CMB2/CMB2
  */
 public function register_meta_box()
 {
  /**
   * Initiate the metabox
   */
  $cmb = new_cmb2_box(array(
   'id'           => 'flexi_metabox',
   'title'        => __('Flexi Meta Controls', 'cmb2'),
   'object_types' => array('flexi'), // Post type
   'context'      => 'normal',
   'priority'     => 'high',
   'show_names'   => true, // Show field names on the left
   // 'cmb_styles' => false, // false to disable the CMB stylesheet
   // 'closed'     => true, // Keep the metabox closed by default
  ));

  // Regular Image Field
  $cmb->add_field(array(
   'name'         => 'Primary image file',
   'desc'         => 'Upload an image',
   'id'           => 'flexi_image',
   'type'         => 'file',
   // Optional:
   'options'      => array(
    'url' => false, // Hide the text input for the url
   ),
   'text'         => array(
    'add_upload_file_text' => 'Add Image File', // Change upload button text. Default: "Add or Upload File"
   ),
   // query_args are passed to wp.media's library query.
   'query_args'   => array(
    //'type' => 'application/pdf', // Make library only display PDFs.
    // Or only allow gif, jpg, or png images
    'type' => array(
     'image/gif',
     'image/jpeg',
     'image/png',
    ),
   ),
   'preview_size' => 'large', // Image size to use when previewing in the admin.
  ));

  // Add other metaboxes as needed
 }
}
