<div class="cta equal-vert-height-container clearfix">
	<div class="shell">
		<div class="eight columns white-text">
			<h3>
				<?php echo get_post_meta($post->ID, 'cta-header', true); ?>
			</h3>
			<p>
				<?php echo get_post_meta($post->ID, 'cta-copy', true); ?>
			</p>
		</div>
		<div class="four columns">
			<button class="blue">Resources</button>
			<button>Get Help Now</button>
		</div>
	</div>
</div>