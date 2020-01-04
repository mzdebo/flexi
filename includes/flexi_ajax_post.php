<?php
//Process ajax form submitted by [flexi-form] shortcode

add_action("wp_ajax_flexi_ajax_post", "flexi_ajax_post");
add_action("wp_ajax_nopriv_flexi_ajax_post", "flexi_ajax_post");
function flexi_ajax_post()
{
 if (
  !isset($_POST['flexi-nonce'])
  || !wp_verify_nonce($_POST['flexi-nonce'], 'flexi-nonce')
 ) {

  exit('The form is not valid');
 }

 // A default response holder, which will have data for sending back to our js file
 $response = array(
  'error' => false,
  'msg'   => 'No Message',
 );

// Example for creating an response with error information, to know in our js file
 // about the error and behave accordingly, like adding error message to the form with JS
 if (trim($_POST['upload_type']) == '') {
  $response['error']         = true;
  $response['error_message'] = 'Improper form fields. Ajax cannot continue.';

  // Exit here, for not processing further because of the error
  exit(json_encode($response));
 }

 $attr = array(
  'class'         => 'pure-form pure-form-stacked',
  'title'         => 'Submit',
  'preview'       => 'default',
  'name'          => '',
  'id'            => get_the_ID(),
  'taxonomy'      => 'flexi_category',
  'tag_taxonomy'  => 'flexi_tag',
  'ajax'          => 'true',
  'media_private' => 'false',
 );
 $form = new Flexi_Shortcode_Form();
 $form->process_forms($attr);

}
