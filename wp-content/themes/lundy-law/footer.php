		<?php if ( !is_page_template('template-home.php' ) ) : ?>
		</div>
		<?php endif; ?>
		
		<div id="footer">
			<div class="footer-top">
				<div class="shell">
					<div class="footer-cols clearfix">
						<div class="col col-locations clearfix">
							<?php 
							$locations = carbon_get_theme_option( 'locations', 'complex' );

							if ( !empty( $locations ) ) : 

								if ( $locations_title = carbon_get_theme_option( 'location_section_title' ) ) : ?>
								<h2><?php echo $locations_title; ?></h2>
								<?php endif; ?>

								<div class="locations clearfix">
									<div class="map">
										<?php foreach ( $locations as $count => $l ) {
											if  ( $l['map'] ) {
												$coordinates = explode( ',', $l['map'] );
												$lat = $coordinates[0];
												$lng = $coordinates[1];
											}

											?>
											<div class="map-holder">
												<?php if ( $l['directions_link'] ) : ?>
												<a href="<?php echo esc_attr( $l['directions_link'] ); ?>" class="map-btn" target="_blank" rel="nofollow">Get Directions<em class="arr"></em></a>
												<?php endif; 

												if ( !empty( $coordinates ) ) : ?>
													<div id="map-<?php echo $count ?>" class="map-wrapper"></div>	 
												<?php endif; ?>
											</div>
											<?php
										} ?>
									</div>

									<div class="address">
										<?php foreach ( $locations as $l ) : ?>
											<div class="address-holder">
												<h4><?php echo $l['location_title'] ?></h4>

												<?php 
												if ( $l['address'] ){
													echo wpautop( $l['address'] );
												} ?>
											</div>
										<?php endforeach; ?>
									</div>

									<div class="cities">
										<ul class="clearfix">
											<?php foreach ( $locations as $l ) {
												echo '<li><a href="#">' . $l['location_title'] . '</a></li>';
											} ?>
										</ul>
									</div>
								</div>
								<!-- end of locations -->
							<?php endif; ?>
						</div>

						<?php 
						$social_icons = carbon_get_theme_option( 'social_icons', 'complex' );
						$additional_links = carbon_get_theme_option( 'additional_link', 'complex' );
						

						if ( !empty( $social_icons ) || !empty( $additional_links ) ) : ?>
							<div class="col">
								<?php if ( $connect_title = carbon_get_theme_option( 'social_section_title' ) ) : ?>
								<h2><?php echo $connect_title; ?></h2>
								<?php endif; ?>

								<?php if ( !empty( $social_icons ) ) : ?>
								<div class="socials clearfix">
									<?php foreach ( $social_icons as $icon ) : ?>
									<a target="_blank" href="<?php echo esc_attr( $icon['link'] ); ?>">
										<?php echo wp_get_attachment_image( $icon['icon'], 'social-icon' ); ?>
									</a>
									<?php endforeach; ?>
								</div>
								<!-- end of socials -->
								<?php endif; ?>

								<?php if ( !empty( $additional_links ) ) : ?>
								<div class="app-newsletter">
									<ul class="clearfix">
										<?php foreach ( $additional_links as $l ) : ?>
										<li>
											<a href="https://www.lundylaw.com/blog/uncategorized/subscribe-to-newsletter/" target="_blank">
												<?php 
												if ( $l['icon'] ) {
													echo wp_get_attachment_image( $l['icon'], 'link-icon' );
													echo '<br />';
												}

												if ( $l['link_text'] ) {
													echo $l['link_text'];	
												}
												?>
											</a>
										</li>
										<?php endforeach; ?>
									</ul>
								</div>
								<!-- end of app-newsletter -->
								<?php endif; ?>

							</div>
						<?php endif; ?>

					</div>
					<!-- end of footer-cols -->
				</div>
			</div>
			<!-- end of footer-top -->

			<div class="footer-bottom">
<br/>Lundy Law does business in Pennsylvania and New Jersey as a Pennsylvania Limited Liability Partnership, and in Delaware as a Limited Liability Company. 
<br/>Legal services in Pennsylvania shall be performed primarily in Philadelphia; New Jersey in Cherry Hill and Delaware in Wilmington. Cases may referred to associated law firms.
				<div class="shell">
					<?php 
					wp_nav_menu( array(
						'theme_location'  => 'footer-menu',
						'container'       => false, 
						'fallback_cb'     => false,
						'depth'			  => 1
					));
					

					if ( $copy = carbon_get_theme_option( 'copyright' ) ) {
						echo wpautop( $copy );
					} ?>					
				</div>
				<?php echo do_shortcode('[gtranslate]'); ?>
			</div>
			<!-- end of footer-bottom -->
		</div>
		<!-- end of footer -->

		<!-- THIRD-PARTY SCRIPTS -->

		<!-- INITIATE BRIGHTCOVE 
		<script type="text/javascript">brightcove.createExperiences();</script>-->

		<!--BEGIN DMI CODE--> 
			<img id='dmiImg' width='1' height='1' src='#' alt='icon' style="height: 0px; position: absolute;" />
			<script type='text/javascript' src='//darc.dmipartners.net/track3/script.aspx?c=69&amp;s=i'></script>
		<!--END DMI CODE-->
		
		<!-- Start Of NGage -->
		<div id="nGageLH" style="visibility:hidden; display: block; padding: 0; position: fixed; left: 0px; bottom: 0px; z-index: 5000;"></div>
		<script type="text/javascript" src="//messenger.ngageics.com/ilnksrvr.aspx?websiteid=192-44-137-224-68-188-17-220" async="async"></script>
		<!-- End Of NGage -->

		<?php wp_footer(); ?>
		
		
		
		
<?php 

// script for Google Maps boxes

$locations = carbon_get_theme_option( 'locations', 'complex' );

if ( !empty( $locations ) ) : 

	foreach ( $locations as $count => $l ) {
		if  ( $l['map'] ) {
			$coordinates = explode( ',', $l['map'] );
			$lat = $coordinates[0];
			$lng = $coordinates[1];
		}
			if ( !empty( $coordinates ) ) : ?>
				  <script type="text/javascript">

		                var center = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>);
		                var id = 'map-'+<?php echo $count; ?>;
		                var map = new google.maps.Map(document.getElementById(id), {
		                    center: center,
		                    zoom: 14,
		                    mapTypeId: google.maps.MapTypeId.ROADMAP
		                });
		                var marker = new google.maps.Marker({
		                    position: center,
		                    map: map,
		                    location: center
		                });

	                </script>   
				<?php endif; ?>
			<?php } ?>
<?php endif; ?>


<?php 
//MIXPO tracking
$mixpo = false;
switch (get_the_id()) {
    case 4:
        $mixpo = 'Home';
        break;
    case 11:
    case 21:
    case 24:
    case 26:
    case 271:
    case 5255:
        $mixpo = 'Our Firm';
        break;
    case 9:
    case 74:
    case 76:
    case 78:
    case 5857:
    case 293:
    case 80:
    case 82:
    case 5855:
    case 84:
    case 86:
    case 88:
    case 5261:
    case 92:
    case 94:
    case 5532:
    case 96:
    case 98:
    case 100:
    case 5891:
        $mixpo = 'Practice Areas';
        break;
    case 144:
    case 5786:
    case 279:
        $mixpo = 'FAQ';
        break;
    case 13:
    case 5846:
    case 5900:
    case 187:
    case 181:
    case 185:
        $mixpo = 'Community';
        break;
    case 17:
    case 5601:
        $mixpo = 'Contact Us';
        break;
    case 426:
        $mixpo = 'Thank You';
        break;
}

if ($mixpo) {
    echo "<img src=\"//player1.mixpo.com/player/analytics/ct?event={$mixpo}\" />";
} else {
    echo "<!-- MIXPO IS OFF -->";
}
//END MIXPO Tracking
?>
		
<?php 
//GOOGLE REMARKETING
if (in_array(get_the_id(), [100,5891]) || has_category('workers-compensation', get_the_id()) ) { //workers comp pages ?>
<!-- remarketing for workers comp page -->
<script type="text/javascript">
(function(a,e,c,f,g,b,d){var h={ak:"948061584",cl:"RuSQCP3cr18QkIuJxAM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
</script>

<?php } else { //all other pages ?>
<!-- remarketing for all other pages -->
<script type="text/javascript">
(function(a,e,c,f,g,b,d){var h={ak:"948061584",cl:"RuSQCP3cr18QkIuJxAM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
</script>

<?php } ?>
	</body>
</html>