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
	<!-- begin TESTTEST -->
	<?php echo do_shortcode('[nav]'); ?>
	<!-- end TESTTEST -->
</div>
<!-- end of sidebar -->