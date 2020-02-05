<?php
//Process ajax form submitted by [flexi-form] shortcode

add_action("wp_ajax_flexi_ajax_delete", "flexi_ajax_delete");
add_action("wp_ajax_nopriv_flexi_ajax_delete", "flexi_my_must_login");
function flexi_ajax_delete()
{
 if (!wp_verify_nonce($_REQUEST['nonce'], "flexi_ajax_delete")) {
  exit("No naughty business please");
 }
 $post_id = $_REQUEST["post_id"];

 $post_author_id = get_post_field('post_author', $post_id);

 if (get_current_user_id() == $post_author_id) {
  flexi_delete_post_media($post_id);
  $data = wp_delete_post($post_id, true);
 } else {
  $data = false;
 }

 if (false === $data) {
  $result['type']       = "error";
  $result['data_count'] = "Fail";
 } else {
  $result['type']       = "success";
  $result['data_count'] = "Pass";
 }

 if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  $result = json_encode($result);
  echo $result;
 } else {
  header("Location: " . $_SERVER["HTTP_REFERER"]);
 }

 die();
}

//Used in ajax call, force users to login before any action.
function flexi_my_must_login()
{
 echo __("Login Please !", "flexi");
 die();
}

function flexi_delete_post_media($post_id)
{

 if (!isset($post_id)) {
  return;
 }
 // Will die in case you run a function like this: delete_post_media($post_id); if you will remove this line - ALL ATTACHMENTS WHO HAS A PARENT WILL BE DELETED PERMANENTLY!
 elseif (0 == $post_id) {
  return;
 }
 // Will die in case you have 0 set. there's no page id called 0 :)
 elseif (is_array($post_id)) {
  return;
 }
 // Will die in case you place there an array of pages.

 else {

  $attachments = get_posts(array(
   'post_type'      => 'attachment',
   'posts_per_page' => -1,
   'post_status'    => 'any',
   'post_parent'    => $post_id,
  ));

  foreach ($attachments as $attachment) {
   if (false === wp_delete_attachment($attachment->ID)) {
    flexi_log('Unable to delete image-' . $post_id);
   }
  }
 }
}
