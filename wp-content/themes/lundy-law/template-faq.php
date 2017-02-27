	<?php  
/*
	Template Name: Template - FAQ
*/

get_header();
	the_post(); 

	$faqs = get_posts( array(
		'posts_per_page' => -1,
		'post_type'      => 'faq',
		'orderby'        => 'menu_order',
		'order'          => 'ASC'
	));
?>
		<div class="main clearfix">
			<?php 
			ll_page_header_image();

			ll_render_faq_section( $faqs, false, false ) ?>
					
			<?php
			wp_reset_query(); 

			$faqs = get_posts( array(
				'posts_per_page' => -1,
				'post_type'      => 'faq',
				'orderby'        => 'menu_order',
				'order'          => 'ASC'
			));
			
			?>

			<?php
			foreach ( $faqs as $faq ) : setup_postdata($faq); ?>
				<h3 id="<?php echo $faq->post_name; ?>"><?php echo get_the_title($faq->ID); ?></h3>
				<?php the_content(); ?>
				<?php wp_reset_postdata(); ?>
			<?php
			endforeach;
			wp_reset_postdata();
			?>	

		</div>
	
<?php get_footer(); ?>