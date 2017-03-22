		<?php if ( !is_page_template('template-home.php' ) ) : ?>
		</div>
		<?php endif; ?>
		
		<div id="footer" class="white-text">
			<div class="footer-top">
				<div class="shell">
					<div class="footer-cols clearfix">
						<div class="col clearfix">
							<img src="http://localhost:8888/lundylaw/wp-content/uploads/lundy-law-logo-white.png">
							<p>
								When you’ve been injured, the last thing on your mind is filing legal paperwork. That’s what we’re here for. Lundy Law has years of experience handling a variety of legal claims, and our attorneys have developed a reputation for getting results.
							</p>
							<a href="#">
								Center City <br>
								1635 Market Street,19th Floor, Philadelphia, PA 19103 <br>
								215-567-3000
							</a>
						</div>
						<div class="col clearfix">
							<h4>Navigate & Connect</h4>
							<?php 
								wp_nav_menu( array(
									'theme_location'  => 'footer-menu',
									'container'       => true, 
									'fallback_cb'     => false,
									'depth'			  => 1
								));
							?>
							<p>Sign up to receive our bi-monthly e-newsletter.</p>


						</div>

					</div>
					<!-- end of footer-cols -->
				</div>
			</div>
			<!-- end of footer-top -->

			<div class="footer-bottom">

				<div class="shell">

					<p>
						Lundy Law does business in Pennsylvania and New Jersey as a Pennsylvania Limited Liability Partnership, and in Delaware as a Limited Liability Company. 
						<br>
						Legal services in Pennsylvania shall be performed primarily in Philadelphia; New Jersey in Cherry Hill and Delaware in Wilmington. Cases may referred to associated law firms.
					</p>
					
					<?php
					if ( $copy = carbon_get_theme_option( 'copyright' ) ) {
						echo wpautop( $copy );
					} ?>					
				</div>
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