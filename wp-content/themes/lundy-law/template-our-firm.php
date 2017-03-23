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


	<div class="clearfix">

		<div class="six columns no-padding" style="background-color:gray">
		</div>

		<div class="six columns no-padding" style="background-color:blue">
		</div>

		<div class="shell" style="	position: absolute;left: 50%;transform: translateX(-50%);">
			<div class="six columns">
			</div>
			<div class="six columns">
				<h3>Lundy Law Personal Injury Attorneys</h3>
				<p>Our personal injury lawyers know that your injuries can change your life — causing serious disability, personal turmoil, and the loss of your job and routine.</p>
				<p>We’re here to help people like you get their lives back to normal. If you’ve been hurt in an accident, we want to help. At Lundy Law, we know the justice system, and we know how to get accident victims the results they need. Contact us today.</p>
			</div>
		</div>

	</div>

	<div class="testimonials">
		<div class="shell">
			TESTIMONIALS
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
				
				<p>Marvin Lundy, founder of Lundy Law, was a personal
injury aorney
in Philadelphia for over 50 years.
During that me,
his law firm earned more than $1
billion on behalf of his clients.
From the start of his career, Mr. Lundy’s policy was
to personally meet with each of the firm’s clients to
discuss their case. His compassion and
understanding of each person’s problems and needs
enabled him to work with the aorneys
and support
personnel within the firm who were best qualified to
manage the client’s needs.
Mr. Lundy worked relessly
to build his pracce
into
one of the Delaware Valley’s most outstanding law firms, and he handled all kinds of personal
injury cases.
Mr. Lundy was an acve
member of many legal organizaons,
including the Pennsylvania and
Philadelphia Bar Associaons,
the American Bar Associaon,
the Philadelphia Bar Foundaon,
the
Philadelphia and Pennsylvania Trial Lawyers associaons,
and the American Associaon
of Jusce.
In addion,
Mr. Lundy served as Governor of the Pennsylvania Associaon
for Jusce
and as
Director of the Philadelphia Associaon
for Jusce.
 Read More
M</p>
				
			</div>
			<div class="four columns">
				
				<?php get_template_part( 'partials/get_help_now_form' ); ?>

			</div>
		</div>
	</div>

	<?php get_template_part( 'partials/logo_carousel' ); ?>

<?php get_footer(); ?>