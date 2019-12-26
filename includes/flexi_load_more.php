<?php
//Load more content ajax call 
add_action("wp_ajax_flexi_load_more", "flexi_load_more");
add_action("wp_ajax_nopriv_flexi_load_more", "flexi_load_more");

function flexi_load_more()
{
	global $wp_query;
	global $post;
	$paged = $_REQUEST["paged"];
	$layout = $_REQUEST['gallery_layout'];
	$popup = $_REQUEST['popup'];
	

	ob_start();
	
	// A default response holder, which will have data for sending back to our js file
	$response = array(
		'error' => false,
		'msg' => 'No Message'
	);

	//var_dump($response);

	//Default settings 
	$postsperpage = 1;
	$perrow = 1;
	$orderby = '';
	$page = '#';



	$post_status = array('publish');
	$author_show = false;


	$args = array(
		'post_type' => 'flexi',
		'posts_per_page' => $postsperpage,
		'paged' => $paged,
		'post_status' => $post_status,
	);
	//echo $post_id;

	$query = new WP_Query($args);

	$put = "";


	//var_dump($args);
	//echo "----";

	$count = 0;
	while ($query->have_posts()) : $query->the_post();
		$count++;
        
        //echo get_the_title()."<br>";
        require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/masonry/loop.php';

	endwhile;

	$put = ob_get_clean();
	//$response['msg'] = "hii";
	$response['msg'] = $put;

	$result = json_encode($response);
	echo $result;
	wp_reset_query();
	die();
}