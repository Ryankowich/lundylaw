<?php
/*
	Template Name: Template - Our Firm
*/

get_header();
	the_post(); 
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('#slider1').tinycarousel();
		});
	</script>
	
	<?php get_template_part( 'partials/hero_highlighted_text' ); ?>

	<div class="cta equal-vert-height-container clearfix">
		<div class="shell">
			<div class="eight columns white-text">
				<h3>Looking for more information?</h3>
				<p>
					We have helpful resources to make sure you have all you need to make the most informed decision. When you are seriously injured, count on a law firm that knows how to deliver serious results—call us at 1-800-LundyLaw®.
				</p>
			</div>
			<div class="four columns">
				<button class="blue">Resources</button>
				<button>Get Help Now</button>
			</div>
		</div>
	</div>

	<div class="faq-section equal-vert-height-container clearfix">
		<div class="shell">
			<div class="eight columns">
				<h3>Frequently Asked Questions</h3>
				
				<div id="accordion">
					<?php 
						$faq = get_posts( array(
							'posts_per_page' =>  8,
							'post_type'      => 'faq',
							'orderby'        => 'rand',
							'order'          => 'ASC'
						));

						if ( $faq ) {
						    foreach ( $faq as $post ) :
						        setup_postdata( $post ); ?>
								<div class="faq twelve columns">
									<h4 class="accordion-toggle blue-text">
										<?php the_title(); ?>
									</h4>
									<div class="accordion-content">
										<?php the_content(); ?>
										<a href="<?php the_permalink(); ?>">Read More...</a>
									</div>
								</div>
						    <?php
						    endforeach; 
						    wp_reset_postdata();
						}
					?>
				</div>
				<button class="blue">See All FAQ</button>
			</div>
			<div class="four columns">
				
				<?php get_template_part( 'partials/get_help_now_form' ); ?>

			</div>
		</div>
	</div>

	<?php get_template_part( 'partials/logo_carousel' ); ?>

<?php get_footer(); ?>