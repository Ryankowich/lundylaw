<?php  

register_post_type('video', array(
	'labels' => array(
		'name'	 => 'Videos',
		'singular_name' => 'Video',
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add new Video' ),
		'view_item' => 'View Video',
		'edit_item' => 'Edit Video',
		'new_item' => __('New Video'),
		'view_item' => __('View Video'),
		'search_items' => __('Search Videos'),
		'not_found' =>  __('No Videos found'),
		'not_found_in_trash' => __('No Videos found in Trash'),
	),
	'menu_icon' => 'dashicons-video-alt3',
	'public' => true,
	'exclude_from_search' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => true,
	'_edit_link' =>  'post.php?post=%d',
	'rewrite' => false,
	'query_var' => true,
	'supports' => array('title', 'page-attributes'),
));


register_post_type('faq', array(
	'labels' => array(
		'name'	 => 'FAQs',
		'singular_name' => 'FAQ',
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add new FAQ' ),
		'view_item' => 'View FAQ',
		'edit_item' => 'Edit FAQ',
		'new_item' => __('New FAQ'),
		'view_item' => __('View FAQ'),
		'search_items' => __('Search FAQs'),
		'not_found' =>  __('No FAQs found'),
		'not_found_in_trash' => __('No FAQs found in Trash'),
	),
	'menu-icon' => 'dashicons-testimonial',
	'public' => true,
	'exclude_from_search' => false,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => true,
	'_edit_link' =>  'post.php?post=%d',
	'rewrite' => array(
		"slug" => "faq",
		"with_front" => false,
	),
	'query_var' => true,
	'supports' => array('title', 'editor', 'page-attributes', 'thumbnail' ),
));