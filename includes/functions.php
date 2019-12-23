<?php
//
// All commonly used function are listed
//
//Return image url
function flexi_image_src($size, $post = '')
{
    if ($post == '')
        global $post;

    $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size);
    if ($image_attributes) {
        return $image_attributes[0];
    } else {
        return plugins_url('../public/images/noimg.png', __FILE__);
    }
}