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
			<button class="blue">See Practice Areas</button>
		</h2>
	</div>
</div>