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
			</div>
		</div>
	</div>

	<div class="testimonials clearfix">
		<div class="shell">
			<div class="two columns"></div>
			<div class="eight columns">
				<i class="fa fa-quote-left fa-3x"></i>
				<h3>TESTIMONIALS</h3>
				<p>“I could call my attorney anytime. He always returned my calls. He was compassionate. If I had a problem, like not getting my workers’ comp checks, my attorney and my legal assistant were right on it.”</p>
				<p class="name">John Doe, <i>Lundy Law Client 2016</i></p>
			</div>
		</div>
	</div>

	<?php get_template_part( 'partials/cta' ); ?>

	<div class="faq-section equal-vert-height-container clearfix">
		<div class="shell">
			<div class="eight columns">
				
				<p>Marvin Lundy, founder of Lundy Law, was a personal injury aorney in Philadelphia for over 50 years. During that me, his law firm earned more than $1 billion on behalf of his clients. From the start of his career, Mr. Lundy’s policy was to personally meet with each of the firm’s clients to discuss their case. His compassion and understanding of each person’s problems and needs enabled him to work with the aorneys and support personnel within the firm who were best qualified to manage the client’s needs. Mr. Lundy worked relessly to build his pracce into one of the Delaware Valley’s most outstanding law firms, and he handled all kinds of personal injury cases. Mr. Lundy was an acve member of many legal organizaons, including the Pennsylvania and Philadelphia Bar Associaons, the American Bar Associaon, the Philadelphia Bar Foundaon, the Philadelphia and Pennsylvania Trial Lawyers associaons, and the American Associaon of Jusce. In addion, Mr. Lundy served as Governor of the Pennsylvania Associaon for Jusce and as Director of the Philadelphia Associaon for Jusce.Marvin Lundy, founder of Lundy Law, was a personal injury aorney in Philadelphia for over 50 years. During that me, his law firm earned more than $1 billion on behalf of his clients. From the start of his career, Mr. Lundy’s policy was to personally meet with each of the firm’s clients to discuss their case. His compassion and understanding of each person’s problems and needs enabled him to work with the aorneys and support personnel within the firm who were best qualified to manage the client’s needs. Mr. Lundy worked relessly to build his pracce into one of the Delaware Valley’s most outstanding law firms, and he handled all kinds of personal injury cases. Mr. Lundy was an acve member of many legal organizaons, including the Pennsylvania and Philadelphia Bar Associaons, the American Bar Associaon, the Philadelphia Bar Foundaon, the Philadelphia and Pennsylvania Trial Lawyers associaons, and the American Associaon of Jusce. In addion, Mr. Lundy served as Governor of the Pennsylvania Associaon for Jusce and as Director of the Philadelphia Associaon for Jusce. Read More M</p>
				
			</div>
			<div class="four columns">
				
				<?php get_template_part( 'partials/get_help_now_form' ); ?>

			</div>
		</div>
	</div>

	<?php get_template_part( 'partials/logo_carousel' ); ?>

<?php get_footer(); ?>