<?php 

get_header('lp');
	the_post(); ?>
	<div id="banner_area" class="clearfix">
		<div class="logo_area_mobile">
			<?php $header_image = carbon_get_theme_option( 'header_image' );
			if ( $slogan || $header_image ) : ?>
				<?php  if ( $header_image ) : ?>
					<div class="phone">
						<a href="tel:180058639529"><?php echo wp_get_attachment_image( $header_image, 'header-image' ); ?></a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="background_img">
			<?php the_post_thumbnail( 'full' ); ?>
			<div class="lundy_title">
			    <h1><?php echo get_post_meta( get_the_ID(), 'action_headline', true ) ?></h1>
			    <h2><?php echo get_post_meta( get_the_ID(), 'action_desc', true ) ?></h2>
			</div>
		</div>
		<div class="container">
			<div class="banner_form five columns">
				<div class="form_headline">
					<div class="logo_area">
						<?php if ( in_category('drug-injury') ) { ?>
						<img src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/logo_druginjury.png">
						<?php } else { ?>
						<img src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/logo.png">
						<?php } ?>
					</div>
					<p class="desktop_disclaimer">Se Habla Español</p>
				</div>
				<?php echo do_shortcode( '[contact-form-7 id="6705" title="Lundy Law | Landing Pages"]' ); ?>
				<p class="mobile_disclaimer">Se Habla Español</p>
			</div>
		</div>
		<!-- end of header-top -->
	</div>
	<!-- end of header -->
	<div class="container clearfix youtube_area">
		<div class="content">
			<div class="six columns">
				<p class="yt_content"><?php echo get_post_meta( get_the_ID(), 'yt_content', true ) ?></p>
			</div>			
			<div class="six columns">
			    <div class="yt_vid"><?php echo get_post_meta( get_the_ID(), 'yt_vid', true ); ?></div>
			</div>
		</div>
	</div><!-- end of content -->
	<div class="testimonials">
		<div class="container numbers">
			<h3>Winning for our client is our job, and we’re really good at it.</h3>
			<div id="next" alt="Next" title="Next">
				<div class="arrow-right"></div>
			</div>
			<div id="prev" alt="Prev" title="Prev">				
				<div class="arrow-left"></div>
			</div>
			<div id="slider">
			<?php if(!is_paged()) { ?>
			<?php
				/* global $post;
			    $term_id = 0;
			    $post_terms = wp_get_object_terms( $post->ID, 'category', array( 'fields' => 'ids' ) );
			    if( ! empty( $post_terms ) ) {
			        $term_id = $post_terms[0];
			    }			        
			    var_dump($post_terms);
			    echo $post_terms;
				$args = array( 
					'post_type' => 'custom_cases', 
					'posts_per_page' => 5, 
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'id',
							'terms' => 13,
						),
					),
				);
				$loop = new WP_Query( $args );
				$count=1; */
				
				if ( in_category('general') ) { 
					$args = array( 'post_type' => 'custom_cases', 'posts_per_page' => 5, );
					$loop = new WP_Query( $args ); ?>
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>			
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p><?php echo get_post_meta( get_the_ID(), 'case_type', true ) ?></p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p><?php echo get_post_meta( get_the_ID(), 'case_amount_earned', true ) ?></p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p><?php echo get_post_meta( get_the_ID(), 'case_state', true ) ?></p></h4>
								</div>
							</div>
						</div>				
						<?php endwhile; ?>
					</div>
					<?php wp_reset_query(); 
					} elseif ( in_category('auto-accident') ) { ?>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Auto Accident</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $4.5 Million</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>New Jersey</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Auto Accident</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $4 Million</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Auto Accident</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $595,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Auto Accident</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $995,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>New Jersey</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Auto Accident</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $190,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Delaware</p></h4>
								</div>
							</div>
						</div>						
					</div>											    	
					<?php } elseif ( in_category('workers-compensation') ) { ?>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Workers' Compensation</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $440,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Workers' Compensation</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $195,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>	
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Workers' Compensation</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $320,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>
					</div>	
					<?php } elseif ( in_category('slip-and-fall') ) { ?>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Slip & Fall</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $550,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Slip & Fall</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $570,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>New Jersey</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Slip & Fall</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $490,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Pennsylvania</p></h4>
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="four columns">
									<h4><span>Case Type:</span><p>Slip & Fall</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case Amount:</span><p>More than $270,000</p></h4>
								</div>
								<div class="four columns">
									<h4><span>Case State:</span><p>Delaware</p></h4>
								</div>
							</div>
						</div>
					</div>	
					<?php } elseif ( in_category('drug-injury') ) { ?>
						<div class="slide">
							<div class="slide-copy">
								<div class="six columns">
									<h4><span>Case Type:</span><p>Hormone Therapy</p></h4>
								</div>
								<div class="six columns">
									<h4><span>Case Amount:</span><p>More than $3.4 Million</p></h4>
								</div>
								<div class="four columns">
									<!--<h4><span>Case State:</span><p>Pennsylvania</p></h4>-->
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="six columns">
									<h4><span>Case Type:</span><p>Gadolinium</p></h4>
								</div>
								<div class="six columns">
									<h4><span>Case Amount:</span><p>More than $720,000</p></h4>
								</div>
								<div class="four columns">
									<!--<h4><span>Case State:</span><p>Pennsylvania</p></h4>-->
								</div>
							</div>
						</div>
						<div class="slide">
							<div class="slide-copy">
								<div class="six columns">
									<h4><span>Case Type:</span><p>ACTOS</p></h4>
								</div>
								<div class="six columns">
									<h4><span>Case Amount:</span><p>More than $625,000</p></h4>
								</div>
								<div class="four columns">
									<!--<h4><span>Case State:</span><p>Pennsylvania</p></h4>-->
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
			<?php } ?>
		</div>
		<div class="container">
			<figure class="lundy_test four columns">
			  <figcaption>
			    <blockquote>
			      <p>I received a call back within 5 minutes of my request to see someone. I was very encouraged after speaking with her that I’ve done the right thing!</p>
			    </blockquote>
			    <h3>D. Eldrige</h3>
			  </figcaption>
			</figure>
			<figure class="lundy_test four columns">
			  <figcaption>
			    <blockquote>
			      <p>I recommend to anyone that needs attorney assistance to reach out to Lundy Law before any others. They are very professional and will work very hard for you.</p>
			    </blockquote>
			    <h3>K. Kauffeld</h3>
			  </figcaption>
			</figure>
			<figure class="lundy_test four columns">
			  <figcaption>
			    <blockquote>
			      <p>Lundy Law made me feel comfortable and at ease through my tragedy.  I really appreciate all of their help and hard work. Thank you!</p>
			    </blockquote>
			    <h3>Anonymous</h3>
			  </figcaption>
			</figure>
		</div>
	</div>
	<div class="benefits container">
		<div class="seven columns">
			<h4>WHY TRUST US</h4>
			<?php the_content(); ?>
			<a href="#top" class="wpcf7-submit benefits_Btn">CONTACT US NOW</a>
		</div>
		<div class="five columns">
			<ul>
				<li><img class="checkmark" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/checkmark.png"> You won’t pay us a penny until you get paid.</li>
				<li><img class="checkmark" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/checkmark.png"> Live people available 24/7.</li>
				<li><img class="checkmark" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/checkmark.png"> Free consultation.</li>
				<li><img class="checkmark" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/checkmark.png"> Get the money you deserve.</li>
				<li><img class="checkmark" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/checkmark.png"> Experienced trial lawyers.</li>
				<li><img class="checkmark" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/checkmark.png"> Helping the community for almost 60 years.</li>
			</ul>
		</div>
		<div id="bar_associations" class="twelve columns">
			<div class="three columns"><img src="//i.imgur.com/ivLUe0u.png"></div>
			<div class="two columns"><img src="//i.imgur.com/VZrnv7I.png"></div>
			<div class="one columns"><img src="//i.imgur.com/f81fwzz.png"></div>
			<div class="one columns"><img src="//i.imgur.com/H9DWFWJ.png"></div>
			<div class="three columns"><img src="//i.imgur.com/IJ8lBqu.png"></div>
			<div class="one columns"><img src="http://lawyers.lawyerlegion.com/images/associations/seals/aaj.png"></div>
	
		</div>
	</div>
	<script>
		jQuery(document).ready(function(){
			var cf7input = jQuery( ".wpcf7-form-control" );
			  if ( cf7input.parent().is( "span" ) ) {
			    cf7input.unwrap();
			  } else {
			    cf7input.wrap( "<span></span>" );
			}
			function updateText(event){
		    var input=jQuery(this);
		    setTimeout(function(){
		      var val=input.val();
		      if(val!="")
		        input.parent().addClass("form-control-float");
		      else
		        input.parent().removeClass("form-control-float");
		    },1)
		  }
		  jQuery(".form-control input").keydown(updateText);
		  jQuery(".form-control input").change(updateText);
		  jQuery(".form-control textarea").keydown(updateText);
		  jQuery(".form-control textarea").change(updateText);
		  
		  // options
		  var speed = 400; //transition speed - fade
		  var autoswitch = true; //auto slider options
		  var autoswitch_speed = 2500; //auto slider speed
			
			// add first initial active class
			jQuery(".slide").first().addClass("active");
			
			// hide all slides
			jQuery(".slide").hide;
			
			// show only active class slide
			jQuery(".active").show();
			
			// Next Event Handler
			jQuery('#next').on('click', nextSlide);// call function nextSlide
			
			// Prev Event Handler
			jQuery('#prev').on('click', prevSlide);// call function prevSlide
			
			// Auto Slider Handler
			if(autoswitch == true){
				setInterval(nextSlide,autoswitch_speed);// call function and value 4000
			}
			
			// Switch to next slide
			function nextSlide(){
				jQuery('.active').removeClass('active').addClass('oldActive');
				if(jQuery('.oldActive').is(':last-child')){
					jQuery('.slide').first().addClass('active');
				} else {
					jQuery('.oldActive').next().addClass('active');
				}
				jQuery('.oldActive').removeClass('oldActive');
				jQuery('.slide').fadeOut(speed);
				jQuery('.active').fadeIn(speed);
			}
			
			// Switch to prev slide
			function prevSlide(){
				jQuery('.active').removeClass('active').addClass('oldActive');
				if(jQuery('.oldActive').is(':first-child')){
					jQuery('.slide').last().addClass('active');
				} else {
					jQuery('.oldActive').prev().addClass('active');
				}
				jQuery('.oldActive').removeClass('oldActive');
				jQuery('.slide').fadeOut(speed);
				jQuery('.active').fadeIn(speed);
			}
		});
	</script>
	<!-- end of container -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-close">X</div>
			<div class="container">
				<div class="banner_form twelve columns">
					<div class="form_headline">
						<div class="logo_area">
							<?php if ( in_category('drug-injury') ) { ?>
							<img src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/logo_druginjury.png">
							<?php } else { ?>
							<img src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/logo.png">
							<?php } ?>
						</div>
						<p class="desktop_disclaimer">Se Habla Español</p>
					</div>
					<?php echo do_shortcode( '[contact-form-7 id="6705" title="Lundy Law | Landing Pages"]' ); ?>
					<p class="mobile_disclaimer">Se Habla Español</p>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-overlay"></div>
<?php get_footer('lp'); ?>