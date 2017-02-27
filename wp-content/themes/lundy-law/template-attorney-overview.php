<?php 
/*
	Template Name: Template - Attorney Overview
*/

get_header();
	the_post(); ?>

		<?php ll_page_header_image();

		if ( get_post_type() != 'faq' ) {
			ll_breadcrumbs(); 	
		}
		?>

		<div class="container clearfix">
			<div class="content">
				<?php ll_page_title(); ?>
					


				<?php the_content(); ?>

			<div class="attorney-wrapper clearfix">
			<?php 
				$args = array(
				    'post_type' => 'page',
				    'posts_per_page' => -1,
				    'meta_query' => array(
				        array(
				            'key' => '_wp_page_template',
				            'value' => 'template-attorney.php'
				        )
				    ),
				    'orderby' => 'menu_order',
				    'order' => 'ASC',
				);

				$the_pages = new WP_Query( $args );
				if( $the_pages->have_posts() ){
				    // set variables here, outside loop, if needed
				    
				    while( $the_pages->have_posts() ){
				            $the_pages->the_post();
							$attorney_photo = carbon_get_post_meta( get_the_ID(), 'attorney_photo' );
							$attorney_name = carbon_get_post_meta( get_the_ID(), 'attorney_name' );
					?>
					
					<div class="attorney-listing">
						<a href="<?php echo get_permalink(); ?>"><img alt="attorney photo" src="<?php echo $attorney_photo ;?>" /></a>
						<br />
						<a href="<?php echo get_permalink(); ?> "><?php echo $attorney_name ;?></a>
					</div>
					
					
					
				   <?php }
				}
				wp_reset_postdata();
			 ?>

			</div><!-- /.clearfix -->
			</div>
			<!-- end of content -->

			<?php get_sidebar('page'); ?>
		</div>
		<!-- end of container -->
<?php get_footer(); ?>