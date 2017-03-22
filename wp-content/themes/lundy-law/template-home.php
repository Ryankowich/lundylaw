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
	<div class="hero-background white-text">
		<div class="shell">
			<h2>
				<span class="highlight blue">Winning hundreds of millions</span>
				<br>
				<span class="highlight blue">for our clients in Pa, NJ & DE</span>
				<br>
				<span class="highlight blue">for over 55 years.</span>
				<br>
				<button class="blue">Meet Our Attorneys</button>
				<button class="blue">See Practice Areas</button>
			</h2>
		</div>
	</div>
	<div class="three-descriptors clearfix equal-vert-height-container">
		<div class="shell white-text">
			<div class="four columns">
				<h3>Our Service Areas</h3>
				<p>We help injured people in Pennsylvania, New Jersey, and Delaware with offices throughout the Delaware Valley and Lehigh Valley, including Philadelphia, Cherry Hill, Wilmington, Bethlehem, and Reading.</p>
			</div>
			<div class="four columns">
				<h3>Our Service Areas</h3>
				<p>We get the results they need. We’ve collected hundreds of millions of dollars in settlements and successful verdicts for our clients.</p>
			</div>
			<div class="four columns">
				<h3>Our Service Areas</h3>
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

	<div class="cta clearfix">
		<div class="shell">
			<div class="eight columns white-text">
				<h3>Looking for more information?</h3>
				<p>
					We have helpful resources to make sure you have all you need to make the most informed decision. When you are seriously injured, count on a law firm that knows how to deliver serious results—call us at 1-800-LundyLaw®.
				</p>
			</div>
			<div class="four columns">
				<button>Resources</button>
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
									<h5 class="accordion-toggle blue-text">
										<?php the_title(); ?>
									</h5>
									<h6 class="accordion-content">
										<?php the_content(); ?>
										<a href="<?php the_permalink(); ?>">Read More...</a>
									</h6>
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
				<!-- Static form -->
				<div class="form get-help-now">

					<form action="/thanks/#wpcf7-f5156-p4-o1" method="post" class="wpcf7-form" novalidate="novalidate">
					<div style="display: none;">
						<input type="hidden" name="_wpcf7" value="5156">
						<input type="hidden" name="_wpcf7_version" value="4.3.1">
						<input type="hidden" name="_wpcf7_locale" value="en_US">
						<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f5156-p4-o1">
						<input type="hidden" name="title" value="Lundy Law | Quick Contact Form">
					</div>	
						 <!-- <input type="hidden" name="formuser" value="llw" /> -->
						<div class="twelve columns">
							<div class="form-slogan white-text">
								<h3>Contact Us To Get Help Now</h3>
							</div>
							<input type="text" class="field required" name="your-name"  title="Your Name" value="" placeholder="NAME"/>
						</div>
						<div class="six columns">
							<input type="text" class="field required phone-number" name="your-phone" title="Phone Number" value="" placeholder="PHONE"/>
						</div>
						<div class="six columns">
							<input type="text" class="field required email-address" name="your-email" title="Email Address" value="" placeholder="EMAIL"/>
						</div>
						<div class="twelve columns">
							<textarea class="textarea required" name="your-message" title="Message" placeholder="MESSAGE"></textarea>
						</div>
						<div class="twelve columns">
							<span class="wpcf7-form-control-wrap pooh-bear-wrap" style="display:none !important;visibility:hidden !important;"><input class="wpcf7-form-control wpcf7-text pooh-bear"  type="text" name="pooh-bear" value="" size="40" tabindex="-1" /><br><small>Please leave this field empty.</small></span>
							<input type="submit" class="submit-btn wpcf7-form-control wpcf7-submit button" value="Get Help Now" />
							<img class="ajax-loader" src="http://www.lundylaw.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;">
						</div>
					</form>
					<div class="wpcf7-response-output wpcf7-display-none"></div>
				</div>
				<!-- end of form -->
			</div>
		</div>
	</div>

	<div class="logo-carousel">
		<div class="shell">
			<div id="slider1">
				<a class="buttons prev" href="#">&#60;</a>
				<div class="viewport">
					<ul class="overview">
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
					</ul>
					<ul class="overview">
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
						<li>TESTING</li>
					</ul>
				</div>
				<a class="buttons next" href="#">&#62;</a>
			</div>
		</div>
	</div>

<?php get_footer(); ?>