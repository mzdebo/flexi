<?php
//Load more content ajax call 
add_action("wp_ajax_flexi_load_more", "flexi_load_more");
add_action("wp_ajax_nopriv_flexi_load_more", "flexi_load_more");

function flexi_load_more()
{
	global $wp_query;
	global $post;
	$paged = $_REQUEST["max_paged"];
	$layout = $_REQUEST['gallery_layout'];
	$popup = $_REQUEST['popup'];
	$album = $_REQUEST['album'];
	$search =  $_REQUEST['search'];
	$postsperpage= $_REQUEST['postsperpage'];
	$orderby= $_REQUEST['orderby'];
	$user= $_REQUEST['user'];
	$keyword= $_REQUEST['keyword'];
	ob_start();
	
	// A default response holder, which will have data for sending back to our js file
	$response = array(
		'error' => false,
		'msg' => 'No Message'
	);

	//var_dump($response);


        //Publish Status
        $post_status = array('publish');

    
    if ($album != "" && $keyword != "")
		$relation = "AND";
	else
		$relation = "OR";

	if ($album != "" || $keyword != "") {
		$args = array(
			'post_type' => 'flexi',
			'paged' => $paged,
			's' => $search,
			'posts_per_page' => $postsperpage,
			'orderby' => $orderby,
			'order'   => 'DESC',
			'author_name' => $user,
			'tax_query' => array(
				'relation' => $relation,
				array(
					'taxonomy' => 'flexi_category',
					'field'    => 'slug',
					'terms'    => explode(',', $album),
					//'terms'    => array( 'mobile', 'sports' ),
					//'include_children' => 0 //It will not include post of sub categories
				),

				array(
					'taxonomy' => 'flexi_tag',
					'field'    => 'slug',
					'terms'    => explode(',', $keyword),
					//'terms'    => array( 'mobile', 'sports' ),
				),

			)
		);
	} else {
		$args = array(
			'post_type' => 'flexi',
			's' => $search,
			'paged' => $paged,
			'posts_per_page' => $postsperpage,
			'author_name' => $user,
			'post_status' => $post_status,
			'orderby' => $orderby,
			'order'   => 'DESC',


		);
	}

	$query = new WP_Query($args);

	$put = "";


	//var_dump($args);
	//echo "----";

	$count = 0;
	while ($query->have_posts()) : $query->the_post();
		$count++;
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