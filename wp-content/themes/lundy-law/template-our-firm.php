<?php
/*
	Template Name: Template - Our Firm
*/

get_header();
	the_post(); 
?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery('#logo-carousel').tinycarousel({

		});

		jQuery('#testimonial-slider').tinycarousel({
			interval: false,
			buttons: true
		});

		jQuery('#our-firm-slider').tinycarousel({
			interval: false,
			buttons: true
		});
	});
</script>

<?php get_template_part( 'partials/hero_highlighted_text' ); ?>

<div class="two-descriptors clearfix">

	<div class="six columns no-padding">
	</div>

	<div class="six columns no-padding">
	</div>

	<div class="shell">
		<div class="six columns">
		</div>
		<div class="six columns white-text">
			<h3>Lundy Law Personal Injury Attorneys</h3>
			<p>Our personal injury lawyers know that your injuries can change your life — causing serious disability, personal turmoil, and the loss of your job and routine.</p>
			<p>We’re here to help people like you get their lives back to normal. If you’ve been hurt in an accident, we want to help. At Lundy Law, we know the justice system, and we know how to get accident victims the results they need. Contact us today.</p>

			
			<!-- will need to set up functionality here -->
			<div id="our-firm-slider">
				<div class="viewport">
					<ul class="overview">
						<li>
							<p>Our personal injury lawyers know that your injuries can change your life — causing serious disability, personal turmoil, and the loss of your job and routine.</p>
							<p>We’re here to help people like you get their lives back to normal. If you’ve been hurt in an accident, we want to help. At Lundy Law, we know the justice system, and we know how to get accident victims the results they need. Contact us today.</p>

						</li>
						<li>
							<p>Our personal injury lawyers know that your injuries can change your life — causing serious disability, personal turmoil, and the loss of your job and routine.</p>
							<p>We’re here to help people like you get their lives back to normal. If you’ve been hurt in an accident, we want to help. At Lundy Law, we know the justice system, and we know how to get accident victims the results they need. Contact us today.</p>
						</li>
					</ul>
				</div>
				<a class="buttons prev" href="#"><i class="fa fa-chevron-left"></i></a>
				<a class="buttons next" href="#"><i class="fa fa-chevron-right"></i></a>
			</div>


		</div>
	</div>
</div>

<div class="meet-our-founder clearfix">
	<div class="shell">
		<div class="six columns">
			<img src="/lundylaw/wp-content/themes/lundy-law/images-add_to_live_after_dev/marvin-lundy-headshot.png" alt="">
		</div>
		<div class="six columns">
			<h3>Meet Our Founder</h3>
			<p>Marvin Lundy, founder of Lundy Law, was a persnal injury attorney in Philadelphia for over 50 years. During that time, his law firm earned more than $1 billin on behalf of his clients.</p>
			<p>From the start of his career, Mr. Lundy's policy was to personally meet with each of the firm's clients to discuss their case. His compassion and understanding of each person's problems and needs enabled him to work with the attornets and support personnel within the firm who were best qualified to manafe the client's needs.</p>
			<a href="#">Read More</a>
		</div>
	</div>
</div>

<?php get_template_part( 'partials/cta' ); ?>

<div class="clients-first-section equal-vert-height-container clearfix">
	<div class="shell">
		<div class="eight columns">
			<h3>Putting Clients First</h3>
			<img src="/lundylaw/wp-content/themes/lundy-law/images-add_to_live_after_dev/lundy-video-still.png" alt="">
			<p>At Lundy Law, our personal injury attorneys know that when it’s between money and people, people come first every single time. That’s why we pride ourselves on taking cases that other law firms won’t—we aren’t afraid to take cases that might not be the easiest to win, but that stand to help the people who need it most.</p>
			<p>No matter what happened to you, if you’ve been injured in an accident, contact Lundy Law. Fill out a free initial consultation form or call us at 1-800-LundyLaw® today. Our bilingual professionals can assist you in English or Spanish, so call now.</p>
		</div>
		<div class="four columns">
			
			<?php get_template_part( 'partials/get_help_now_form' ); ?>

		</div>
	</div>
</div>

<?php get_template_part( 'partials/testimonial_slider' ); ?>

<?php get_template_part( 'partials/logo_carousel' ); ?>

<?php get_footer(); ?>