<?php
//log_me('This is a message for debugging purposes. works if debug is enabled.');
function flexi_log($message)
{
	if (WP_DEBUG === true) {
		if (is_array($message) || is_object($message)) {
			error_log(print_r($message, true));
		} else {
			error_log($message);
		}
	}
}

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

//Get link and added attributes of the image based on lightbox
function flexi_image_data($size='full',$post='')
{
    $data=array();
    $data['title']=get_the_title();
    $lightbox_settings = get_option( 'flexi_detail_settings' );
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
            $data['url']=flexi_image_src('full', $post);
            $data['extra']='data-fancybox="image"';
        }
        else
        {
            $data['url']=get_permalink();
            $data['extra']='';
        }
        return $data;
}
/**
 * Get default plugin settings.
 *
 * @since  1.0.0
 * @return array $defaults Array of plugin settings.
 */
function flexi_get_default_settings() {
    
    //Lightbox Enabled
    flexi_set_option('lightbox_switch', 'flexi_detail_settings', 1);
    return;	
}

/**
 * Get the value of a settings field
 *
 * @param string $field_name settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function flexi_get_option($field_name, $section = 'flexi_detail_settings', $default = '')
{
    //Example
    //flexi_get_option('field_name', 'setting_name', 'default_value');

	$options = (array) get_option($section);

    if (isset($options[$field_name])) 
    {
		return $options[$field_name];
    } else 
    {
        //Set the default value if not found
        flexi_set_option($field_name, $section, $default);
		
	}

	return $default;
}

//Set options in settings
function flexi_set_option($field_name, $section = 'flexi_general_settings', $default = '')
{
//Example
//flexi_set_option('field_name', 'setting_name', 'default_value');
    $options = (array) get_option($section);
   	$options[$field_name] = $default;
	update_option($section, $options);

	return;
}

//Create required pages
function flexi_create_pages()
{
    global $wpdb;
    if (!$wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[flexi-gallery]%'")) 
    {

		$aid = wp_insert_post(array('post_title' => 'Flexi Gallery', 'post_content' => '[flexi-gallery]', 'post_type' => 'page', 'post_status' => 'publish'));
		flexi_set_option('main_page', 'flexi_image_layout_settings', $aid);
		
		$str_post_image = '
		[flexi-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" ajax="true"]
		[flexi-form-tag type="post_title" title="Title" value="" placeholder="main title"]
		[flexi-form-tag type="category" title="Select category" taxonomy="flexi_cate" filter="image"]
		[flexi-form-tag type="tag" title="Insert tag"]
		[flexi-form-tag type="article" title="Description"  placeholder="Content"]
		[flexi-form-tag type="file" title="Select file"]
		[flexi-form-tag type="submit" name="submit" value="Submit Now"]
		[/flexi-form]
		';

		$bid = wp_insert_post(array('post_title' => 'Post Image', 'post_content' => $str_post_image, 'post_type' => 'page', 'post_status' => 'publish'));
		flexi_set_option('post_image_page', 'flexi_form_settings', $bid);
		

		$str_post_embed = '
		[flexi-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" ajax="true" post_type="video_url"] 
        [flexi-form-tag type="post_title" title="Video Title" value="" placeholder="main title"]
        [flexi-form-tag type="category" title="Select category" taxonomy="flexi_cate" filter="embed" ]
        [flexi-form-tag type="tag" title="Insert tag"]
        [flexi-form-tag type="article" title="Description"  placeholder="Content"]
        [flexi-form-tag type="video_url" title="Submit public embed URL" placeholder="http://" required="true"]
        [flexi-form-tag type="submit" name="submit" value="Submit URL"]
        [/flexi-form]
		';

		$cid = wp_insert_post(array('post_title' => 'Post Video URL', 'post_content' => $str_post_embed, 'post_type' => 'page', 'post_status' => 'publish'));
		flexi_set_option('post_embed_page', 'flexi_form_settings', $cid);
		
		$did = wp_insert_post(array('post_title' => 'My Gallery', 'post_content' => '[flexi-gallery user="show_mine" layout="filter" perpage="50"]', 'post_type' => 'page', 'post_status' => 'publish'));
		flexi_set_option('my_gallery', 'flexi_image_layout_settings', $did);
		

		$eid = wp_insert_post(array('post_title' => 'Edit UPG Post', 'post_content' => '[flexi-edit]', 'post_type' => 'page', 'post_status' => 'publish'));
		flexi_set_option('edit_flexi_page', 'flexi_form_settings', $eid);
		
	}

}