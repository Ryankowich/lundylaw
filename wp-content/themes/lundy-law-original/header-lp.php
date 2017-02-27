<!DOCTYPE html>
<html>
<head profile="http://gmpg.org/xfn/11" rel="">
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no" />
	<title><?php wp_title(''); ?></title>
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" />
	<?php wp_head(); ?>
	<script type="text/javascript" src= "//n7m9g9p3.ssl.hwcdn.net/s/r/single/57d71af4fd2bc7220873fd57.js?v=1"></script>
	<script>
	// script to allow chat script to be placed in footer of document, promoting faster page load
	// declare global ChatURL variable
	var ChatURL = "";
	// function to determine whether chat script has loaded in footer of document
	function loadChat() {
		if (ChatURL != "") {
			openWindow(ChatURL, false);
		}
		
		else {
			alert("Please wait until the page finishes loading to use our chat feature.");
		}
	}
	</script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-57929890-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
	<script type="text/javascript">
	(function(a,e,c,f,g,b,d){var h={ak:"948061584",cl:"RuSQCP3cr18QkIuJxAM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
	</script>
</head>
<?php
$template_class = '';
if (!is_front_page())
	$template_class .= "page-sub";
else
	$template_class .= "page-home";

if (is_404())
	$template_class .= " page-404";
?>
<body <?php body_class($template_class); ?>>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5GRH7X"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5GRH7X');</script>
<!-- End Google Tag Manager -->