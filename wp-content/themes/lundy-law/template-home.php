<?php
/*
	Template Name: Template - Home
*/

get_header();
	the_post(); 
?>

	<div class="hero-background">
		<div class="shell">
			<h2>
				Winning hundreds of millions <br>
				for our clients in Pa, NJ & DE <br>
				for over 55 years.
			</h2>
		</div>
	</div>
	<div class="three-descriptors clearfix">
		<div class="shell">
			<div class="three columns">
				<h3>Our Service Areas</h3>
				<p>We help injured people in Pennsylvania, New Jersey, and Delaware with offices throughout the Delaware Valley and Lehigh Valley, including Philadelphia, Cherry Hill, Wilmington, Bethlehem, and Reading.</p>
			</div>
			<div class="three columns">
				<h3>Our Service Areas</h3>
				<p>We get the results they need. We’ve collected hundreds of millions of dollars in settlements and successful verdicts for our clients.</p>
			</div>
			<div class="three columns">
				<h3>Our Service Areas</h3>
				<p>We take cases that other firms won’t. That’s because we care about helping people, no matter how hard the challenge.</p>
			</div>
		</div>
	</div>

	<div class="shell">
		<h3>Our Practice Areas</h3>
		<p>Whether you’ve suffered an auto accident or slip and fall, need help with a workers’ compensation claim, or are having a hard time getting approved for Social Security Disability benefits, our Pennsylvania, New Jersey and Delaware personal injury attorneys want to help with your case. </p>
		<?php get_template_part( 'partials/filtered_practice_areas' ); ?>
	</div>

	<div class="shell">
		<div class="main clearfix">
			<div class="content clearfix">
				<div class="cnt">
					
					<?php
					ll_page_title();
					
					the_content();
					?>
				</div>
				<!-- end of cnt -->

				<?php 
				$awards = carbon_get_post_meta( get_the_ID(), 'awards', 'complex' );

				if ( !empty( $awards ) ) : ?>
				<div class="awards">
					<div class="awards-inner">
						<?php foreach ( $awards as $award ) {
							echo wp_get_attachment_image( $award['award'], 'award' );
						} ?>
					</div>
				</div>
				<!-- end of awards -->
				<?php endif; ?>
			</div>
			<!-- end of content -->

			

		</div>
		<!-- end of main -->

		<?php 
		$sections = carbon_get_post_meta( get_the_ID(), 'content_sections', 'complex' );

		if ( !empty( $sections ) ) : ?>
		
		<div class="sections">
			
			<div class="two columns">TESTING</div>
			<div class="two columns">TESTING</div>
			<?php

			foreach ( $sections as $section ) :

				if ( $section['_type'] == '_faq_section' ) :
					
					$faqs = get_posts( array(
						'posts_per_page' => abs( $section['posts_count'] ),
						'post_type'      => 'faq',
						'orderby'        => 'rand',
						'order'          => 'ASC'
					));

					ll_render_faq_section( $faqs, $section['section_title'] );

				endif;

				if ( $section['_type'] == '_content_section') : ?>

					<div class="section">
						<?php ll_home_page_section_title( $section['section_title'] ); ?>

						<div class="section-holder" style="background-image: url(<?php echo wp_get_attachment_url( $section['background_image'] ) ?>);">
							<?php 

							if ( $section['content'] ) {
								echo wpautop( $section['content'] );
							} 

							if ( $section['button_link'] && $section['button_text'] ) : ?>
								<a href="<?php echo esc_attr( $section['button_link'] ); ?>" class="btn"><span><?php echo $section['button_text'] ?></span><em class="arr"></em></a>
							<?php endif; ?>
						</div>
					</div>
					<!-- end of section -->

				<?php endif;

			endforeach; ?>
			
			</div>
			<div class="sections">
						
				<!-- Static form -->
				<div class="form">

					<form action="/thanks/#wpcf7-f5156-p4-o1" method="post" class="wpcf7-form" novalidate="novalidate">
					<div style="display: none;">
						<input type="hidden" name="_wpcf7" value="5156">
						<input type="hidden" name="_wpcf7_version" value="4.3.1">
						<input type="hidden" name="_wpcf7_locale" value="en_US">
						<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f5156-p4-o1">
						<input type="hidden" name="_wpnonce" value="776a6ae8af">																			
			
						<input type="hidden" name="title" value="Lundy Law | Quick Contact Form">
					</div>	
						 <!-- <input type="hidden" name="formuser" value="llw" /> -->
						<div class="col">
							<div class="form-slogan">
								<h3>Get Help Today</h3>
								<p>Fill out this form to receive a free initial consultation.</p>
							</div>
							<label>NAME:</label>
							<input type="text" class="field required" name="your-name"  title="Your Name" value="" placeholder="First, Last"/>
						</div>
						<div class="col">
							<label>phone:</label>
							<input type="text" class="field required phone-number" name="your-phone" title="Phone Number" value="" placeholder="xxx-xxx-xxxx"/>
							<label>email:</label>
							<input type="text" class="field required email-address" name="your-email" title="Email Address" value="" placeholder="name@email.com"/>
						</div>
						<div class="col">
							<label>message:</label>
							<textarea class="textarea required" name="your-message" title="Message" placeholder="How can we help you?"></textarea>
						</div>
						<span class="wpcf7-form-control-wrap pooh-bear-wrap" style="display:none !important;visibility:hidden !important;"><input class="wpcf7-form-control wpcf7-text pooh-bear"  type="text" name="pooh-bear" value="" size="40" tabindex="-1" /><br><small>Please leave this field empty.</small></span>
						<input type="submit" class="submit-btn wpcf7-form-control wpcf7-submit" value="submit form" />
						<img class="ajax-loader" src="http://www.lundylaw.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;"></form>
				<div class="wpcf7-response-output wpcf7-display-none"></div>
					<a href="/free/" class="form-button">
						<strong>Get Help Today</strong>
						Click here to receive a<br />
						free initial consultation.
					</a>
				</div>
				<!-- end of form -->
			</div>
			<!-- /.sections -->
		
		<?php endif; ?>

	</div>
<?php get_footer(); ?>