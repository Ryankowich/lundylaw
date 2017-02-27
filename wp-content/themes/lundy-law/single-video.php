<?php  define('WP_USE_THEMES', false); require('./wp-blog-header.php'); ?>

<?php 

the_post();

// set defaults
$video_id = carbon_get_post_meta( get_the_ID(), 'video_id' );

$video_player = carbon_get_post_meta( get_the_ID(), 'video_player' );
if (empty($video_player))
	$video_player = "3519949921001";

$video_key = carbon_get_post_meta( get_the_ID(), 'video_key' );
if (empty($video_key))
	$video_key = "AQ~~,AAAAsMO7Cfk~,Mr4-ZzN4AmheMHdb6Vtvq0e4DA-6qoRT";

?>
<html>
	
	<title><?php wp_title(); ?></title>

	<head>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" media="all"/>
	</head>

	<body>
		<div class="videoplayer">
			<div class="brightcove widescreen">
				<!-- Start of Brightcove Player -->
				<div style="display:none">
				</div>
				<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
				<object id="myExperience<?php echo $video_id; ?>" class="BrightcoveExperience" type="video">
				  <param name="bgcolor" value="#FFFFFF" />
				  <param name="width" value="640" />
				  <param name="height" value="360" />
				  <param name="playerID" value="<?php echo $video_player; ?>" />
				  <param name="playerKey" value="<?php echo $video_key; ?>" />
				  <param name="isVid" value="true" />
				  <param name="isUI" value="true" />
				  <param name="dynamicStreaming" value="true" />
				  <param name="videoSmoothing" value="true"/>
				  <param name="wmode" value="transparent" />  
				  <param name="@videoPlayer" value="<?php echo $video_id; ?>" />
				</object>
				<script type="text/javascript">brightcove.createExperiences();</script>
				<!-- End of Brightcove Player -->
			</div><!-- /.brightcove -->
		</div><!-- /.videoplayer -->
	</body>
</html>