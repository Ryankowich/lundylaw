<?php 
/*
	Template Name: Template - Attorney Profile
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
					
				<?php
				$attorney_quote = carbon_get_post_meta( get_the_ID(), 'attorney_quote' );
				$attorney_phone = carbon_get_post_meta( get_the_ID(), 'attorney_phone' );
				$attorney_email = carbon_get_post_meta( get_the_ID(), 'attorney_email' );
				$flag = (empty($attorney_phone) || empty($attorney_email) ? true : false);
				?>

				<?php if ($attorney_quote || $attorney_phone || $attorney_email) { ?>
				<div class="attorney-info clearfix">
					<?php if ($attorney_quote) { ?>
					<?php if (!$flag) { ?>
					<div class="quote-wrapper">
					<?php } ?>
						<blockquote>
							<?php echo $attorney_quote; ?>
						</blockquote>
					<?php if (!$flag) { ?>
					</div><!-- /.quote-wrapper -->
					<?php } ?>
					<? } ?>
					<?php if (!$flag) { ?>
					<div class="info-wrapper">
						<div class="contact-info">
							<h2>Contact</h2>
							<div class="contact-details clearfix">
								<a class="email" href="mailto:<?php echo $attorney_email; ?>">Email</a>
								<span class="phone">
									<i>Phone</i><br />
									<?php echo $attorney_phone; ?>
								</span>
							</div>
						</div><!-- /.contact-info -->
					</div><!-- /.info-wrapper -->
					<?php } ?>
				</div><!-- /.attorney-info -->
				<?php } ?>
				
				<?php the_content(); ?>

			</div>
			<!-- end of content -->

			<?php get_sidebar('page'); ?>
		</div>
		<!-- end of container -->
<?php get_footer(); ?>