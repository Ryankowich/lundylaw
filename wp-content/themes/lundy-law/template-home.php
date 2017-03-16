<?php
/*
	Template Name: Template - Home
*/

get_header();
	the_post(); 
?>
	<div class="banner-home">
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="banner">

			<?php 

			if (class_exists('Dynamic_Featured_Image')) {
				global $dynamic_featured_image;
				$featured_images = $dynamic_featured_image->get_all_featured_images();
				$slideshow = (sizeof($featured_images) > 1) ? true : false;
			}

			?>

			<?php
			if (class_exists('Dynamic_Featured_Image') && $slideshow) {
			?>
			<div class="flexslider">
				<ul class="slides">
					 <?php
					 foreach($featured_images as $image) {
					 	
					 	$url_image = str_replace('http://www.lundylaw.com/wp-content/uploadshttps:','http:',$image['full']);
					 	$id = $dynamic_featured_image->get_image_id($url); 
					 	$alt = $dynamic_featured_image->get_image_alt_by_id($id);
					 	$caption = $dynamic_featured_image->get_image_caption_by_id($id);
					 ?>
 					<li>
					 	<img src="<?php echo $url_image; ?>" alt="<?php echo $alt; ?>" />
					 	<div class="banner-cnt"><h2 class="h1"><?php echo $caption ?></h2></div><!-- /.banner-cnt -->
 					</li>
				    <?php } ?>
				</ul>
			</div><!-- /.flexslider -->
			<?php 
			} 
			
			else {
				echo the_post_thumbnail( 'home-featured-image' );
				echo "<div class='banner-cnt'><h2 class='h1'>".get_post(get_post_thumbnail_id())->post_excerpt."</h2></div>";
			}

			?>
		</div>
		<!-- end of banner -->
		<?php endif; ?>

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
	<!-- end of banner-home -->

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

			<?php if ( is_active_sidebar( 'home-sidebar' ) ) : ?>
				<?php get_sidebar( 'home' ); ?>
			<!-- end of sidebar -->
			<?php endif; ?>

		</div>
		<!-- end of main -->

		<?php get_template_part( 'partials/filtered_practice_areas' ); ?>

		<?php 
		$sections = carbon_get_post_meta( get_the_ID(), 'content_sections', 'complex' );

		if ( !empty( $sections ) ) : ?>
		
		<div class="sections">
			
			<?php

			foreach ( $sections as $section ) :
							// original video section - DO NOT DELETE!!!!!!!!!!!

				if ( $section['_type'] == '_video_section' ) :

					$videos = get_posts( array(
						'posts_per_page' => abs( $section['posts_count'] ),
						'post_type'      => 'video',
						'orderby'          => 'menu_order',
						'order'            => 'ASC'

					));

					if ( !empty( $videos ) ) : ?>
						<div class="videos clearfix">
							
							<?php ll_home_page_section_title( $section['section_title'] ); ?>

							<?php foreach ( $videos as $v ) : 
								if ( $video = carbon_get_post_meta( $v->ID, 'video_url' ) ) :
									$embed = ll_get_video_url( $video );
									?>
									<div class="video">
										<div class="video-img">
											<a href="<?php echo $video;?>">
												
												<?php 
												if ( $thumb = carbon_get_post_meta( $v->ID, 'video_thumb' ) ) {
													echo wp_get_attachment_image( $thumb, 'video-thumb' ); 	
												}
												?>

												<span class="play-btn"></span>
											</a>
										</div>
										<h5><?php echo $v->post_title ?></h5>
									</div>
							<?php endif;
							endforeach; ?>
						</div>
						<!-- end of videos -->
					<?php 
					endif;

				endif;
				/*
				
				if ( $section['_type'] == '_video_section' ) :

					$videos = get_posts( array(
						'posts_per_page' => abs( $section['posts_count'] ),
						'post_type'      => 'video',
						'orderby'          => 'menu_order',
						'order'            => 'ASC'
					));

					if ( !empty( $videos ) ) : ?>
						<div class="videos clearfix">
							
							<?php ll_home_page_section_title( $section['section_title'] ); ?>

							<?php foreach ( $videos as $v ) : 
								if ( $video = carbon_get_post_meta( $v->ID, 'video_id' ) ) :
									$embed = ll_get_video_url( $video );
									?>
									<div class="video">
										<div class="video-img">
											<a href="<?php echo get_permalink($v->ID); ?>">
												
												<?php 
												if ( $thumb = carbon_get_post_meta( $v->ID, 'video_thumb' ) ) {
													echo wp_get_attachment_image( $thumb, 'video-thumb' ); 	
												}
												?>

												<span class="play-btn"></span>
											</a>
										</div>
										<h5><?php echo $v->post_title ?></h5>
									</div>
							<?php endif;
							endforeach; ?>
						</div>
						<!-- end of videos -->
					<?php 
					endif;

				endif;*/

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
			
			</div><!-- /.sections -->
		
		<?php endif; ?>

	</div>
<?php get_footer(); ?>