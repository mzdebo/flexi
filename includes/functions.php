<?php
//
// All commonly used function are listed
//
//Return image url
function flexi_image_src($size='thumbnail', $post = '')
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

//Get link of the image based on lightbox enabled
function flexi_image_link($size='full',$post='')
{
    $lightbox_settings = get_option( 'flexi_lightbox_settings' );
    if ( empty( $lightbox_settings['lightbox_switch'] ) ) {
        $lightbox=false;
    }
    else
    {
        $lightbox=true;
    }
    
    if ($post == '')
        global $post;

        if($lightbox)
        {
            return flexi_image_src('full', $post);
        }
        else
        {
            return get_permalink();
        }
}
/**
 * Get default plugin settings.
 *
 * @since  1.0.0
 * @return array $defaults Array of plugin settings.
 */
function flexi_get_default_settings() {
    $defaults = array(
        'flexi_lightbox_settings' => array(
			'lightbox_switch' => 1
		),
    );
    return $defaults;	
}