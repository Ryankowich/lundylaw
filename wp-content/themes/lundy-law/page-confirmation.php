<?php
/*
Template Name: Template - Confirmation / Thanks Page
*/
?>
<?php 

get_header();
	the_post(); ?>

		<?php ll_page_header_image();

		if ( get_post_type() != 'faq' ) {
			ll_breadcrumbs(); 	
		}
		?>

		<div class="container clearfix">
			<div class="content">
				<?php
				ll_page_title();

				the_content();
				?>
			</div>
			<!-- end of content -->

			<?php get_sidebar('page'); ?>

		</div>
		<!-- end of container -->
		
		<!-- Google Code for Web Form Conversion Page -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1011599919;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "qkdpCPGChAMQr5Sv4gM";
		var google_conversion_value = 0;
		/* ]]> */
		</script>
		<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1011599919/?label=qkdpCPGChAMQr5Sv4gM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>

<?php get_footer(); ?>