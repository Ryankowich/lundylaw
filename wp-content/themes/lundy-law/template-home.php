<?php
/*
	Template Name: Template - Home
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

	<div class="three-descriptors clearfix equal-vert-height-container">
		<div class="shell white-text">
			<div class="four columns">
				<h3>Our Service Areas</h3>
				<p>We help injured people in Pennsylvania, New Jersey, and Delaware with offices throughout the Delaware Valley and Lehigh Valley, including Philadelphia, Cherry Hill, Wilmington, Bethlehem, and Reading.</p>
			</div>
			<div class="four columns">
				<h3>If We Don't Win, You Don't Pay</h3>
				<p>We get the results they need. We’ve collected hundreds of millions of dollars in settlements and successful verdicts for our clients.</p>
			</div>
			<div class="four columns">
				<h3>We Care About Your Case</h3>
				<p>We take cases that other firms won’t. That’s because we care about helping people, no matter how hard the challenge.</p>
			</div>
		</div>
	</div>

	<div class="practice-areas clearfix">
		<div class="shell">
			<h3>Our Practice Areas</h3>
			<p>Whether you’ve suffered an auto accident or slip and fall, need help with a workers’ compensation claim, or are having a hard time getting approved for Social Security Disability benefits, our Pennsylvania, New Jersey and Delaware personal injury attorneys want to help with your case. </p>

			<?php get_template_part( 'partials/filtered_practice_areas' ); ?>
		</div>
	</div>

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