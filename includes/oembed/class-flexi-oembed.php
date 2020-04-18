<?php
class Flexi_oEmbed
{

 public function __construct()
 {

 }

 public function getUrlThumbnail($url, $post_id)
 {
  require_once ABSPATH . 'wp-includes/class-wp-oembed.php';
  $oembed = new WP_oEmbed;

  if (!wp_http_validate_url($url)) {
   return FLEXI_ROOT_URL . 'public/images/noimg_thumb.jpg';
  }

  $raw_provider = parse_url($oembed->get_provider($url));
  if (isset($raw_provider['host'])) {

   $provider = $oembed->discover($url);
   $video    = $oembed->fetch($provider, $url);
   if (isset($video) && false != $video) {
    // Video Provider Name
    $provider = $video->provider_name;

    if (isset($video->thumbnail_url)) {
     add_post_meta($post_id, 'flexi_image', $video->thumbnail_url);
     return $video->thumbnail_url;
    } else {
     return FLEXI_ROOT_URL . 'public/images/noimg_thumb.jpg';
    }
   } else {
    return FLEXI_ROOT_URL . 'public/images/noimg_thumb.jpg';
   }

  }
 }

 /**
  * Extracts the daily motion id from a daily motion url.
  * Returns false if the url is not recognized as a daily motion url.
  */
 public function getDailyMotionId($url)
 {

  //return 'http://www.dailymotion.com/thumbnail/video/' . $id;

  if (preg_match('!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m)) {
   if (isset($m[6])) {
    return $m[6];
   }
   if (isset($m[4])) {
    return $m[4];
   }
   return $m[2];
  }
  return false;
 }

}
