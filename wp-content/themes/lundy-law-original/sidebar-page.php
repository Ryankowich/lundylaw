<div id="sidebar">

	<ul>
	<?php
		if (is_404()) {
			dynamic_sidebar('404-sidebar');
		} 
		
		else {
			dynamic_sidebar('page-sidebar');
		}
	?>
	</ul>

	<?php echo do_shortcode('[nav]'); ?>
</div>
<!-- end of sidebar -->