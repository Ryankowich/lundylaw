<!-- start filtered practice areas -->

<!-- still needs to be hooked up to isotope -->

<div id="test">

	<h1>filtered practice areas</h1>

	<?php 
 
    $menu_items = wp_get_nav_menu_items('Practice Areas');
 
    $menu_list = '<div id="menu-practice-areas" class="grid">';
 
    foreach ( (array) $menu_items as $menu_item ) {

    	$post_id = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );

    	$img = get_the_post_thumbnail ( $post_id, 'thumbnail' );

        $title = $menu_item->title;

        $url = $menu_item->url;

        $menu_list .= '<div class="element-item"><a href="' . $url . '">' . $img . $title . '</a></div>';
    }

    $menu_list .= '</div><br>';

	// $menu_list now ready to output
	echo $menu_list;

	?>

	<h1>end filtered practice areas</h1>

</div>

<!-- end filtered practice areas -->