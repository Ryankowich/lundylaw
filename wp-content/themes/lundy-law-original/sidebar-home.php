<!-- start home sidebar -->
<div id="sidebar">
	<ul>
	<?php
		if (is_404()) {
			dynamic_sidebar('404-sidebar');
		} 
		
		else {
			dynamic_sidebar('home-sidebar');
		}
	?>
	</ul>
</div>
<!-- end of sidebar -->