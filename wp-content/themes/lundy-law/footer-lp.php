		<div id="footer">
			<div class="google_maps">
				<img src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/google_maps.png">
			</div>
			<div class="container">
				<div class="five columns">
				</div>
				<div class="seven columns addresses">
					<div class="twelve column">
						<div class="address-holder six columns">
							<h4>Philadelphia, PA</h4>
							<p>1635 Market Street<br>19th Floor</p>
							<p>Philadelphia, PA, 19103</p>
							<p><a href="tel:215-567-3000">215-567-3000</a></p>
						</div>
						<div class="address-holder six columns">
							<h4>Cherry Hill, NJ</h4>
							<p>1040 North Kings Highway</p>
							<p>Suite 305</p>
							<p>Cherry Hill, New Jersey 08034</p>
							<p><a href="tel:856-755-9000">856-755-9000</a></p>
						</div>
						<div class="address-holder six columns">
							<h4>Wilmington, DE</h4>
							<p>1600 Pennsylvania Avenue<br>Suite C</p>
							<p>Wilmington, DE 19806</p>
							<p><a href="tel:302-351-0301">302-351-0300</a></p>
						</div>													
						<div class="address-holder six columns">
							<h4>Bethlehem, PA</h4>
							<p>Park Plaza Professional Center<br>Suite 302</p>
							<p>3400 Bath Pike</p>
							<p>Bethlehem, PA 18017</p>
							<p><a href="tel:180058639529">1-800-LUNDYLAW</a></p>
						</div>					
					</div>
				</div>		
			</div>
			<div class="footer-bottom clearfix">
				<div class="container">
					<div class="twelve column social">
						<div class="offset-by-four four columns">
								<h5 class="social_title">Connect with us:</h5>
								<div class="socials clearfix">
									<a target="_blank" href="https://twitter.com/Lundy_Law">
										<img width="69" height="69" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/twitter.png" class="attachment-social-icon" alt="Read Tweets from the offices of Lundy Law today.">
									</a>
									<a target="_blank" href="https://www.facebook.com/LundyLaw">
										<img width="69" height="69" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/facebook.png" class="attachment-social-icon" alt="Like Lundy Law on Facebook">					
									</a>
									<a target="_blank" href="https://www.instagram.com/1800lundylaw/">
										<img width="69" height="69" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/instagram.png" class="attachment-social-icon" alt="Add Lundy Law to your circles on Google+">									</a>
									<a target="_blank" href="https://www.youtube.com/user/LundyLaw">
										<img width="69" height="69" src="<?php echo get_stylesheet_directory_uri() ?>/lp_parts/images/youtube.png" class="attachment-social-icon" alt="Subscribe to our YouTube Channel! Visit Lundy Law's YouTube channel today.">									
									</a>
																	
								</div>
							<!-- end of socials -->
						</div>
					</div>
				</div>	
				<p class="disclaimer">Cases may be referred to associated law firms.</p>
				<p class="disclaimer">

All elements of this website are copyrighted materials for LundyLaw © 2016 - 2017</p>				
			</div>
			<!-- end of footer-bottom -->
		</div>
		<!-- end of footer -->

		<!-- THIRD-PARTY SCRIPTS -->

		<!-- INITIATE BRIGHTCOVE 
		<script type="text/javascript">brightcove.createExperiences();</script>-->

		<!--BEGIN DMI CODE--> 
			<img id='dmiImg' width='1' height='1' src='#' alt='icon' style="height: 0px; position: absolute; width: 0px; visibility:hidden;" />
			<script type='text/javascript' src='//darc.dmipartners.net/track3/script.aspx?c=69&amp;s=i'></script>
		<!--END DMI CODE-->
		
		<!-- Start Of NGage -->
		<div id="nGageLH" style="visibility:hidden; display: block; padding: 0; position: fixed; left: 0px; bottom: 0px; z-index: 5000;"></div>
		<script type="text/javascript" src="https://messenger.ngageics.com/ilnksrvr.aspx?websiteid=192-44-137-224-68-188-17-220" async="async"></script>
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
    echo "<img src=\"http://player1.mixpo.com/player/analytics/ct?event={$mixpo}\" />";
} else {
    echo "<!-- MIXPO IS OFF -->";
}
//END MIXPO Tracking
?>
		
<?php 
//GOOGLE REMARKETING
if (in_array(get_the_id(), [100,5891]) || has_category('workers-compensation', get_the_id()) ) { //workers comp pages ?>

<?php } else { //all other pages ?>
<!-- remarketing for all other pages -->
<script type="text/javascript">
(function(a,e,c,f,g,b,d){var h={ak:"948061584",cl:"RuSQCP3cr18QkIuJxAM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
</script>

<?php } ?>
	</body>
</html>