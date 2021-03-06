<!-- start filtered practice areas -->

<div id="filtered-practice-areas" class="sections">

	<h2>Practice Areas</h2>

    <div class="button-group filter-button-group">
        <button data-filter="*">show all</button>
        <button data-filter=".auto">auto</button>
        <button data-filter=".not-auto">not auto</button>
    </div>

	<?php 
 
    $menu_items = wp_get_nav_menu_items('Practice Areas');
 
    $menu_list = '<div id="menu-practice-areas" class="grid">';
 
    foreach ( (array) $menu_items as $menu_item ) {

    	$post_id = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );

    	$img = get_the_post_thumbnail ( $post_id, 'thumbnail' );

        $title = $menu_item->title;

        $url = $menu_item->url;

        //check if the titles contain certain words, and add classes based on that
        if (strpos($title, 'Auto') !== false) {
            $class = 'auto';
        } else {
            $class = 'not-auto';
        }

        $menu_list .= '<div class="element-item ' . $class . '"><a href="' . $url . '">' . $img . '<span>' . $title . '</span>' . '</a></div>';
    }

    $menu_list .= '</div><br>';

	// $menu_list now ready to output
	echo $menu_list;

	?>

</div>

<!-- end filtered practice areas -->