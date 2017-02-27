<?php 
get_header();
	the_post(); ?>

		<?php ll_page_header_image();

		if ( get_post_type() != 'faq' ) {
			ll_breadcrumbs(); 	
		}
		?>

		<div class="container clearfix">
			<div class="content">
				<h1>404: Page Not Found</h1>
				<p>We’re sorry, but the page you requested can’t be found. Please use your browser’s back button or the main navigation menu to visit a different area of the website.</p>
				<p>If you can’t find the information you’re looking for, call us 24/7 at 1-800-LundyLaw®, or fill out our <a href="/free/">free online form</a> to be contacted by a member of our legal team. We’re here to answer your questions so you can get the help you need.</p>
			</div>
			<!-- end of content -->

			<?php get_sidebar(); ?>

		</div>
		<!-- end of container -->
<?php get_footer(); ?>