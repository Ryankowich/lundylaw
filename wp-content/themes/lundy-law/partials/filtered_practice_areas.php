<!-- start filtered practice areas -->

<div id="filtered-practice-areas" class="sections">

    <div class="button-group filter-button-group">
        <button data-filter="*" class="is-checked">Most Searched</button>
        <button data-filter=".personal-injury">Personal Injury</button>
        <button data-filter=".work-related">Work Related</button>
        <button data-filter=".auto">Automobiles</button>
    </div>

	<?php 
 
    $menu_items = wp_get_nav_menu_items('Practice Areas');
 
    $menu_list = '<div id="menu-practice-areas" class="grid">';
 
    foreach ( (array) $menu_items as $menu_item ) {

    	$post_id = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );

    	$img = get_the_post_thumbnail ( $post_id, 'thumbnail' );

        //$img = get_the_post_thumbnail ( $post_id, array( 300, 300) );

        $title = $menu_item->title;

        $url = $menu_item->url;

        //check if the titles contain certain words, and add classes based on that
        if (strpos($title, 'Auto') !== false) {
            $class = 'auto';
        } else {
            $class = 'personal-injury';
        }

        $menu_list .= '<div class="element-item ' . $class . '"><a href="' . $url . '">' . $img . '<span>' . $title . '</span>' . '</a></div>';

    }

    $menu_list .= '</div><br>';

	// $menu_list now ready to output
	echo $menu_list;

	?>

    <a href="#">VIEW MORE</a><button class="blue">See All Practice Areas</button>

</div>

<!-- end filtered practice areas -->