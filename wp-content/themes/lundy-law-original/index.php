<?php get_header(); ?>

		<div class="container clearfix">
			<?php ll_page_header_image(); ?>
			<div class="content">
				<?php ll_page_title(); ?>
	
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<div <?php post_class() ?>>
							<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><em><?php the_title(); ?></em></a></h3>
							<div class="entry">
								<p class="date"><?php the_time('F j, Y') ?></p>
								<?php the_content(__('Read the rest of this entry &raquo;')); ?>
							</div>
						</div>

					<?php endwhile; ?>

					<?php if (  $wp_query->max_num_pages > 1 ) : ?>
						<div class="navigation">
							<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')); ?></div>
							<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')); ?></div>
						</div>
					<?php endif; ?>
					
				<?php else : ?>
					<div id="post-0" class="post error404 not-found">
						<?php if ( is_404() ) : ?>
							<p><?php printf(__('Please check the URL for proper spelling and capitalization. If you\'re having trouble locating a destination, try visiting the <a href="%1$s">home page</a>'), get_option('home')); ?></p>
						
						<?php else: ?>	
						<h2>Not Found</h2>
						
						<div class="entry">
							<?php  
								if ( is_category() ) { // If this is a category archive
									printf("<p>Sorry, but there aren't any posts in the %s category yet.</p>", single_cat_title('',false));
								} else if ( is_date() ) { // If this is a date archive
									echo("<p>Sorry, but there aren't any posts with this date.</p>");
								} else if ( is_author() ) { // If this is a category archive
									$userdata = get_user_by('id', get_queried_object_id());
									printf("<p>Sorry, but there aren't any posts by %s yet.</p>", $userdata->display_name);
								} else if ( is_search() ) {
									echo("<p>No posts found. Try a different search?</p>");
								} else {
									echo("<p>No posts found.</p>");
								}
							?>
							<?php get_search_form(); ?>
						</div>
						<?php endif; ?>

					</div>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
<?php get_footer(); ?>