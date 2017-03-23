<!--
	these fields must be created and filled in on the backend of every page that this applies to
-->
<div class="hero-background white-text">
	<div class="shell">
		<h2>

			<span class="highlight blue"><?php echo get_post_meta($post->ID, 'highlighted-text-line-1', true); ?></span>
			<br>
			<span class="highlight blue"><?php echo get_post_meta($post->ID, 'highlighted-text-line-2', true); ?></span>
			<br>
			<span class="highlight blue"><?php echo get_post_meta($post->ID, 'highlighted-text-line-2', true); ?></span>
			<br>
			<button class="blue">Meet Our Attorneys</button>

			<!-- possible issues: https://developer.wordpress.org/reference/functions/is_page_template/#cannot-be-used-inside-the-loop -->
			<?php if ( is_page_template('template-home.php') ){ ?>
				<button class="blue">See Practice Areas</button>
			<?php } ?>
			
		</h2>
	</div>
</div>