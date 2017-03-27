<!-- TODO: possibly add custom fields -->

<div class="logo-carousel">
	<div class="shell">
		<div id="logo-carousel">
			<div class="viewport">
				<ul class="overview">
					<li>
						<img src="http://findicons.com/files/icons/1341/summertime_snacks/128/cheeseburger.png">
					</li>
					<li>
						<?php if (is_front_page()) {
							echo '<img src="./wp-content/themes/lundy-law/images-add_to_live_after_dev/AV-award-Burbank-DUI-lawyers.png">';
						} else {
							echo '<img src="../wp-content/themes/lundy-law/images-add_to_live_after_dev/AV-award-Burbank-DUI-lawyers.png">';
						} ?>
					</li>
					<li>
						<img src="http://findicons.com/files/icons/1341/summertime_snacks/128/cheeseburger.png">
					</li>
					<li>
						<?php if (is_front_page()) {
							echo '<img src="./wp-content/themes/lundy-law/images-add_to_live_after_dev/super-lawyers-grey.png">';
						} else {
							echo '<img src="../wp-content/themes/lundy-law/images-add_to_live_after_dev/super-lawyers-grey.png">';
						} ?>
						
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>