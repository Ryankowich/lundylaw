<?php

// turn off automatic development updates
define( 'WP_AUTO_UPDATE_CORE', false );

define('CRB_THEME_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('CRB_THEME_VERSION', '1.0'); // change here to force cache refresh
		
# Enqueue Custom Scripts
add_action( 'wp_enqueue_scripts', 'll_enqueue_srcipts' );
function ll_enqueue_srcipts(){
	
	$dir =  get_bloginfo('stylesheet_directory');

	# enqueue jquery
	wp_enqueue_script('jquery');

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );		
	} 
		
	# enqueue custom styles
	if( !is_singular('custom_type') ){
		wp_enqueue_style( 'Questrial-font', '//fonts.googleapis.com/css?family=Questrial' );
		wp_enqueue_style( 'flexslider-css', $dir . '/css/flexslider.css', array(), CRB_THEME_VERSION );
		wp_enqueue_style( 'colorbox-css', $dir . '/css/colorbox.css', array(), CRB_THEME_VERSION );
		wp_enqueue_style( 'style', $dir . '/style.css', array(), CRB_THEME_VERSION );	
		# enqueue custom scripts
		#wp_enqueue_script('jquery.colorbox', $dir . '/js/jquery.colorbox-min.js', array('jquery'),  CRB_THEME_VERSION, true );	
		wp_enqueue_script('gmaps-api', '//maps.googleapis.com/maps/api/js?sensor=true', false,  CRB_THEME_VERSION, true );	
		#wp_enqueue_script('css3-mediaqueries-js', $dir . '/js/css3-mediaqueries.js', array('jquery'),  CRB_THEME_VERSION, true );
		#wp_enqueue_script('jquery.flexslider', $dir . '/js/jquery.flexslider-min.js', array('jquery'),  CRB_THEME_VERSION, true );
		#wp_enqueue_script('functions', $dir . '/js/functions.js', array('jquery'),  CRB_THEME_VERSION, true );
		#wp_enqueue_script('scripts', $dir . '/js/scripts.js', array('jquery'),  CRB_THEME_VERSION, true);
		wp_enqueue_script('all', $dir . '/js/all.js', array('jquery'),  CRB_THEME_VERSION, true);
		wp_enqueue_script('brightcove', '//admin.brightcove.com/js/BrightcoveExperiences.js', false, false, true);
	} else {
		wp_enqueue_style( 'style', $dir . '/lp_parts/style.css', array(), CRB_THEME_VERSION );
	}
}

add_action('after_setup_theme', 'crb_setup_theme');

# To override theme setup process in a child theme, add your own crb_setup_theme() to your child theme's
# functions.php file.
if (!function_exists('crb_setup_theme')) {
	function crb_setup_theme() {
		include_once(CRB_THEME_DIR . 'lib/common.php');
		include_once(CRB_THEME_DIR . 'lib/carbon-fields/carbon-fields.php');

		# Theme supports
		add_theme_support('automatic-feed-links');
		add_theme_support('menus');
		add_theme_support('post-thumbnails');

		# Register Theme Menu Locations
		register_nav_menus(array(
			'main-menu'   =>__('Main Menu'),
			'footer-menu' => __('Footer Menu')
		));

		# Image sizes
		add_image_size( 'slogan', 446, 61, true );
		add_image_size( 'header-image', 490, 61, true );
		add_image_size( 'social-icon', 69, 69, false );
		add_image_size( 'link-icon', 64, 9999, false );
		add_image_size( 'home-featured-image', 1114, 734, true );
		add_image_size( 'featured-image', 960, 277, true );
		add_image_size( 'award', 178, 159, true );
		add_image_size( 'section-image', 960, 304, true );
		add_image_size( 'video-thumb', 306, 172, true );

		# Attach shortcodes
		include_once( CRB_THEME_DIR . 'options/shortcodes.php');

		# Register CPTs
		include_once(CRB_THEME_DIR . 'options/post-types.php');
		
		# Attach custom widgets
		include_once(CRB_THEME_DIR . 'options/widgets.php');
		
		# Add Actions
		add_action('widgets_init', 'crb_widgets_init');

		add_action('carbon_register_fields', 'crb_attach_theme_options');
		// add_action('carbon_after_register_fields', 'crb_attach_theme_help');
	}
}


# Register Sidebars
# Note: In a child theme with custom crb_setup_theme() this function is not hooked to widgets_init
function crb_widgets_init() {
	register_sidebar(
	array(
		'name' => 'Home Sidebar',
		'id' => 'home-sidebar'
		) + crb_widgets_defaults()
	);

	register_sidebar(
	array(
		'name' => 'Default Sidebar',
		'id' => 'default-sidebar'
		) + crb_widgets_defaults()
	);
	
	register_sidebar(
	array(
		'name' => 'Page Sidebar',
		'id' => 'page-sidebar'
		) + crb_widgets_defaults()
	);
	
	register_sidebar(
	array(
		'name' => '404 Sidebar',
		'id' => '404-sidebar'
		)
	);
}

function crb_widgets_defaults(){
	return array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
	);
}

function crb_attach_theme_options() {
	# Attach fields
	include_once(CRB_THEME_DIR . 'options/theme-options.php');
	include_once(CRB_THEME_DIR . 'options/custom-fields.php');
}

function crb_attach_theme_help() {
	# Theme Help needs to be after options/theme-options.php
	include_once(CRB_THEME_DIR . 'lib/theme-help/theme-readme.php');
}

# Fix tags for shortcodes
add_filter('the_content', 'll_shortcode_fix_tags');
function ll_shortcode_fix_tags($content) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}

# Carbon fields for homapage sections
function ll_crb_home_fields( $count ){
	return array(
		Carbon_Field::factory('text', 'section_title'),
		Carbon_Field::factory('text', 'posts_count')
			->set_default_value( $count ),
	);
}

function ll_get_video_url( $video ){
	if (preg_match('~youtube~i', $video)) {
		$video_id = explode( 'watch?v=', $video );
		return '//www.youtube.com/embed/' . $video_id[1];
	} else if (preg_match('~vimeo~i', $video)) {
		preg_match('~vimeo.com/([\d]+)~', $video, $video_id);
		return 'http://player.vimeo.com/video/' . $video_id[1] . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff';
	}
}

function ll_home_page_section_title( $title ){
	if ( $title ) : ?>
	<h2><?php echo $title ?></h2>
	<?php endif; 
}

function ll_page_title() {

	global $post;

	if ( is_singular() ) {
		$title = get_the_title( $post->ID );

		if ( $custom_title = carbon_get_post_meta( $post->ID, 'custom_title') ) {
			$title = $custom_title;
		}
		
	} elseif ( is_search() ) {
		$title = 'Search Results'; 
	} elseif ( is_home() ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( is_404() ) {
		$title = '404 Page Not Found';
	}
	else { 
		if (is_category()) { 
			$title = "Archive for the &#8216;". single_cat_title("", false) .'&#8217; Category';

		} 
		elseif( is_tag() ) { 
			$title = 'Posts Tagged &#8216;'. single_tag_title("", false) .'&#8217;';
		} 
		elseif (is_day()) { 
			$title = 'Archive for '. get_the_time('F jS, Y'); 
		} 
		elseif (is_month()) { 
			$title = 'Archive for '. get_the_time('F, Y'); 
		} 
		elseif (is_year()) { 
			$title = 'Archive for '. get_the_time('Y'); 
		} 
		elseif (is_author()) { 
			$title = 'Author Archive';
		} 
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
			$title = 'Blog Archives';
		}
	}
	echo '<h1>'. $title .'</h1>';
}

# Breadcrumbs
function ll_breadcrumbs($before='<ul class="breadcrumbs clearfix">', $glue='', $after='</ul>') {
	if (is_404()) {
		return;
	}
    global $post, $wp_query;
   
    $stack = array();

    if (is_page()) {
        $page_id = $post->ID;
        $page_obj = get_page($page_id);
       
        $tmp = array();
       
        do {
            $tmp[] = array(
                'title'=>apply_filters('the_title', $page_obj->post_title),
                'link'=>get_permalink($page_obj->ID)
            );
        } while ($page_obj->post_parent!=0 && ($page_obj = get_page($page_obj->post_parent)));
       
        $tmp = array_reverse($tmp);
       
        foreach ($tmp as $breadcrumb_elem) {
            array_push($stack, $breadcrumb_elem);
        }
    } elseif (is_search()) {
        array_push($stack, array(
            'title' => 'Search Results',
            'link' => '#'
        ));
    } else {
    	$posts_page_id = get_option('page_for_posts');
    	if ($posts_page_id && ! (is_single() && get_post_type() == 'event') ) {
    		$posts_page = get_page($posts_page_id);
			array_push($stack, 
				array(
		            'title'=>apply_filters('the_title', $posts_page->post_title),
		            'link'=>get_permalink($posts_page->ID)
		        )
			);
    	}
    	if (is_single() && get_post_type() == 'event') {
			array_push($stack, 
				array(
		            'title'=>'Event - ' . apply_filters('the_title', get_the_title()),
		            'link'=>get_permalink()
		        )
			);
    	} elseif (is_single()) {
			global $post;

			$cats = wp_get_post_categories($post->ID);
			if (!empty($cats[0])) {
	            $ancestors = array_reverse(ll_get_category_parents($cats[0]));
	            foreach ($ancestors as $breadcrumb_elem) {
	                array_push($stack, $breadcrumb_elem);
	            }	
			}

			array_push($stack, 
				array(
		            'title'=>apply_filters('the_title', get_the_title()),
		            'link'=>get_permalink()
		        )
			);

		} elseif (is_category()) {
            $category = get_query_var('cat');
            $ancestors = array_reverse(ll_get_category_parents($category));
           
            foreach ($ancestors as $breadcrumb_elem) {
                array_push($stack, $breadcrumb_elem);
            }
        } else if (is_tag()) {
            array_push($stack, array(
                'title'=>single_tag_title('', false),
                'link'=>get_tag_link(get_query_var('tag'))
            ));
        } else if (is_day() ) {
            array_push($stack, array(
                'title' => get_the_time('F j, Y'),
                'link' => get_day_link(get_the_time('j'), get_the_time('F'),  get_the_time('Y'))
            ));
        } else if (is_month()) {
            array_push($stack, array(
                'title' => get_the_time('F Y'),
                'link' => get_month_link(get_the_time('F'),  get_the_time('Y'))
            ));
        } else if (is_year()) {
            array_push($stack, array(
                'title' => get_the_time('Y'),
                'link' => get_year_link(get_the_time('Y'))
            ));
        } else if(is_author()) {
            array_push($stack, array(
                'title' => 'Posts by ' . get_the_author_meta('display_name', $post->post_author),
                'link' => get_author_posts_url(get_the_author_meta('ID', $post->post_author))
            ));
        }
    }
   
    if (count($stack) < 2) {
        return;
    }
   
    $elems = array();
    $i = 0;
    foreach ($stack as $elem) {
        if ($i==count($stack)-1) {

            $html = '<li>' . $elem['title'] . '</li>';
        } else {
            $html = '<li><a href="' . $elem['link'] . '">' . $elem['title'] . '</a></li>';
        }       
        $elems[] = $html;
        $i++;
    }
   
    echo $before . implode($glue, $elems) . $after;
}

function ll_get_category_parents($cat_id) {
    $return = array();
    $cat = get_category($cat_id);
   
    do {
        $return[] = array(
            'title'=>$cat->name,
            'link'=>get_category_link($cat->term_id)
        );
    } while ($cat->parent!=0 && ($cat = get_category($cat->parent)));
       
    return $return;
}

function ll_page_header_image(){
	global $post;
	
	$image_id = carbon_get_theme_option( 'default_header_image' );
	$image = wp_get_attachment_image( $image_id, 'featured-image');
	
	if ( $post ){
		if ( has_post_thumbnail( $post->ID ) ) {
			$image = get_the_post_thumbnail( $post->ID, 'featured-image' );
		}	
	} 

	if ( $image ) : ?>
	<div class="banner">
		<?php echo $image ?>
	</div>
	<!-- end of banner -->
	<?php endif;

}

function ll_get_page_by_template($template) {
   global $wpdb;
   return $wpdb->get_row(
      "SELECT p.ID, p.post_title
       FROM $wpdb->posts AS p
       INNER JOIN $wpdb->postmeta AS pm
       ON p.ID = pm.post_id
       WHERE meta_key = '_wp_page_template'
       AND post_type = 'page' 
       AND post_status = 'publish'
       AND meta_value = '$template'
       LIMIT 1
   ");
}

// added by JR to allow multiple page returns
function ll_get_pages_by_template($template) {
   global $wpdb;
   return $wpdb->get_row(
      "SELECT p.ID, p.post_title
       FROM $wpdb->posts AS p
       INNER JOIN $wpdb->postmeta AS pm
       ON p.ID = pm.post_id
       WHERE meta_key = '_wp_page_template'
       AND post_type = 'page' 
       AND post_status = 'publish'
       AND meta_value = '$template'
   ");
}


# Render FAQ Section
function ll_render_faq_section( $faqs, $section_title = '', $show_button = true ){
	if ( !empty( $faqs ) ) : ?>
		<div class="faq-section">	
			<?php 
			if ( $section_title ) {
				ll_home_page_section_title( $section_title );
			} else {
				ll_page_title();
			}

			$faq_count = floor( count( $faqs ) / 2 ) - 1; ?>

			<div class="cols clearfix">
				<div class="col">
					<ul>
						<?php foreach ( $faqs as $key => $f ) {
							// changed to work with on-page anchors
							//echo '<li><a href="'. get_permalink( $f->ID ) .'">' . $f->post_title . '</a></li>';
							echo '<li><a href="/faq/#'. $f->post_name .'">' . $f->post_title . '</a></li>';

							if ( $key == $faq_count ) : ?>
									</ul>
								</div>
								<div class="col">
									<ul>
							<?php endif;
						} ?>
					</ul>
				</div>
			</div>

			<?php 
			
			if ( $show_button ){
				
				$faq_page = ll_get_page_by_template('template-faq.php');
				
				if ( !empty( $faq_page) ) : ?>
					<a href="<?php echo get_permalink( $faq_page->ID ); ?>" class="btn"><span>See All FAQ</span><em class="arr"></em></a>
				<?php endif;
			} 

			?>
		</div>
		<!-- end of faq -->
	<?php endif;
}

// allow Editor role to access options - primarily for WordPress SEO and menu editing
function add_theme_caps() {
	$role = get_role( 'editor' );
	$role->add_cap( 'edit_files' );
	$role->add_cap( 'edit_theme_options' );
	$role->add_cap( 'manage_options' );
}
add_action( 'admin_init', 'add_theme_caps');

// adding the function to the Wordpress init
add_action( 'init', 'custom_post_lp');

//Elite SEM - Custom Post Type for Landing Pages
function custom_post_lp() { 
	// creating (registering) the custom type 
	register_post_type( 'custom_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Landing Pages', 'lundywp'), /* This is the Title of the Group */
			'singular_name' => __('Landing Page', 'lundywp'), /* This is the individual type */
			'all_items' => __('All Landing Pages', 'lundywp'), /* the all items menu item */
			'add_new' => __('Add New', 'lundywp'), /* The add new menu item */
			'add_new_item' => __('Add New Landing Page', 'lundywp'), /* Add New Display Title */
			'edit' => __( 'Edit', 'lundywp' ), /* Edit Dialog */
			'edit_item' => __('Edit Landing Pages', 'lundywp'), /* Edit Display Title */
			'new_item' => __('New Landing Page', 'lundywp'), /* New Display Title */
			'view_item' => __('View Landing Page', 'lundywp'), /* View Display Title */
			'search_items' => __('Search Landing Pages', 'lundywp'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'lundywp'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'lundywp'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example landing page', 'lundywp' ), /* Custom Type Description */
			'public' => false,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'lp', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'lp', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'sticky'),
	 	) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	register_taxonomy_for_object_type('category', 'custom_type');
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type('post_tag', 'custom_type');
	
} 
// adding the function to the Wordpress init
add_action( 'init', 'custom_cases');

//Elite SEM - Custom Post Type for Landing Pages
function custom_cases() { 
	// creating (registering) the custom type 
	register_post_type( 'custom_cases', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Cases', 'lundycases'), /* This is the Title of the Group */
			'singular_name' => __('Case', 'lundycases'), /* This is the individual type */
			'all_items' => __('All Cases', 'lundycases'), /* the all items menu item */
			'add_new' => __('Add New', 'lundycases'), /* The add new menu item */
			'add_new_item' => __('Add New Case', 'lundycases'), /* Add New Display Title */
			'edit' => __( 'Edit', 'lundycases' ), /* Edit Dialog */
			'edit_item' => __('Edit Case', 'lundycases'), /* Edit Display Title */
			'new_item' => __('New Case', 'lundycases'), /* New Display Title */
			'view_item' => __('View Case', 'lundycases'), /* View Display Title */
			'search_items' => __('Search Cases', 'lundycases'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'lundycases'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'lundycases'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example case', 'lundycases' ), /* Custom Type Description */
			'public' => false,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite'	=> array( 'slug' => 'lundy_cases', 'with_front' => true ), /* you can specify its url slug */
			'has_archive' => 'lundy_cases', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'sticky'),
			'show_in_menu' => 'edit.php?post_type=custom_type'
	 	) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	register_taxonomy_for_object_type('category', 'custom_cases');
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type('post_tag', 'custom_cases');
	
} 