<?php 
add_shortcode( 'image_box', 'll_image_box_shortcode' );
function ll_image_box_shortcode( $atts, $content = null ){
	return '<div class="no-fee">' . $content . '</div>';
}

// [brightcove id="12345" aspect="widescreen"]
function brightcove_func( $atts ) {
	extract( shortcode_atts( array(
		'id' => '0',
		'format' => 'widescreen',
		'layout' => '',
		'player' => '3519949921001',
		'key'	 => 'AQ~~,AAAAsMO7Cfk~,Mr4-ZzN4AmheMHdb6Vtvq0e4DA-6qoRT'
	), $atts ) );

	$id = "{$id}";
	$format = "{$format}";
	$layout = "{$layout}";
	$player = "{$player}";
	$key = "{$key}";

	$val = '';
	
	switch ($format) {   
	    case 'ws':
			$val = "widescreen";
	        break;
	    case 'widescreen':
			$val = "widescreen";
	        break;
	    case 's':
	        $val = "standard";
	        break;
	    case 'standard':
	        $val = "standard";
	        break;
	    default:
	    	$val = "widescreen";
	}
	
	$format = $val;

	switch ($layout) {  
	    case 'f':
	        $val = "fixed";
	        break;
	    case 'fixed':
	        $val = "fixed";
	        break;
	    case 'i':
	        $val = "inset";
	        break;
	    case 'inset':
	        $val = "inset";
	        break;
	    case 'il':
	        $val = "inset-left";
	        break;
	    case 'inset-left':
	        $val = "inset-left";
	        break;
	    case 'ir':
	        $val = "inset-right";
	        break;
	    case 'inset-right':
	        $val = "inset-right";
	        break;
	    default:
	    	$val = "";
	}
	
	$layout = $val;
	
	$markup = 
		"<div class='videoplayer $layout'>
			<div class='brightcove $format'>
				<div style='display:none'></div>		
				<object id='myExperience$id' class='BrightcoveExperience'>
					<param name='bgcolor' value='#FFFFFF' />
					<param name='playerID' value='$player' />
					<param name='playerKey' value='$key' />
					<param name='isVid' value='true' />
					<param name='isUI' value='true' />
					<param name='dynamicStreaming' value='true' />
					<param name='videoSmoothing' value='true'/> 
					<param name='wmode' value='transparent' />
					<param name='@videoPlayer' value='$id' />
				</object>
			</div>
		</div>";

	return $markup;
}
add_shortcode( 'brightcove', 'brightcove_func' );

// shortcode to print out free consultation form
function freeform_func() {
	$markup = '

		<div class="form free-form-full clearfix">
			<h2><span>Get Help Today</span> Fill out this form to receive a free initial consultation.</h2>
			<form class="clearfix" action="http://www.cjadvertising.com/forms/submit.php" method="post">
			    <input type="hidden" name="title" value="LundyLaw | Free Consultation" />
			    <input type="hidden" name="formuser" value="llw" />
				<div class="col col-1">
					<label for="name">* Name</label>
					<input type="text" name="name" class="required" title="Your Name" value="First, Last" />
					<label for="phone">* Phone</label>
					<input type="text" name="phone" class="required phone-number" title="Phone Number" value="(xxx) xxx-xxxx" />
					<label for="email">* Email</label>
					<input type="text" name="email" class="required email-address" title="Email Address" value="name@email.com" />
				</div><!-- /.column -->
	
				<div class="col col-2">
					<label for="address">Address</label>
					<input type="text" name="address" value="" />
	
					<div class="clearfix">
						<div class="city">
							<label for="city">City</label>
							<input type="text" name="city" value="" />
						</div><!-- /.city -->
						<div class="state">
							<label for="state">State</label>
							<input type="text" name="state" value="" />
						</div><!-- /.state -->
					</div><!-- /.clearfix -->
	
					<label for="zip">Zip</label>
					<input type="text" name="zip" value="" />
				</div><!-- /.column -->
	
				<div class="col col-3">
					<label for="message">* Message</label>
					<textarea class="required" name="message" title="Message">How can we help you?</textarea>
					<input type="submit" value="Submit Form" />
				</div><!-- /.column -->
			</form>
		</div><!-- /.form -->

	';
	
	return $markup;
}
add_shortcode( 'freeform', 'freeform_func' );


// shortcode to print out free consultation form
function careersform_func() {
	$markup = '
	
	<div class="careersform">
		<h2>Career Application</h2>
	    <form name="form97" action="http://www.cjadvertising.com/forms/submit.php" method="post">
    		<input type="hidden" name="title" value="Lundy Law Injury Lawyers | Employment Form" />
		    <input type="hidden" name="formuser" value="lundylaw" />
			<h3>Position Applying For:</h3>
			<select>
				<option value="Select One" selected="SELECTED">Select One</option>
				<option value="Paralegal">Paralegal</option>
				<option value="Litigation Secretary">Litigation Secretary</option>
				<option value="Attorney">Attorney</option>
				<option value="Pre-litigation Case Manager">Pre-litigation Case Manager</option>
				<option value="Receptionist">Receptionist</option>
				<option value="Clerk">Clerk</option>
				<option value="Administrative">Administrative</option>
				<option value="Other">Other</option>
			</select>
			
			<h3>Basic Info:</h3>
			<p>Name:</p>
			<input type="text" name="name" class="REPLACE" />
			
			<p>Home Phone Number:</p>
			<input type="text" name="phone" class="REPLACE" />
			
			<p>Mobile Phone Number:</p>
			<input type="text" name="mobile_phone" class="REPLACE" />
			
			<p>Email Address:</p>
			<input type="text" name="email" class="REPLACE" />
	
			<h3>Availability:</h3>
			<p>When can you start work?</p>
			<select name="date_available">
				<option value="Select One" selected="SELECTED">Select One</option>
				<option value="Immediately">Immediately</option>
				<option value="2 Weeks Notice">2 Weeks Notice</option>
				<option value="Other">Other</option>
			</select>
			
			<p>What are your pay/salary expectations?</p>
			<textarea name="employment_salary1"></textarea>
			
			<h3>Résumé:</h3>
			<p>Please copy and paste your résumé in the provided box below.</p>
			<textarea name="resume"></textarea>
	
			<h3>Cover Letter (optional):</h3>
			<p>Please copy and paste your cover letter in the provided box below.</p>
			<textarea name="cover_letter"></textarea>
			
			<input type="submit" value="Submit Form" />
			
			<p class="note">By clicking the "Submit Form" button, I hereby affirm that the information provided on this agreement is accurate.</p>
		</form>
	</div><!-- /.careersform -->
					
	';

	
	return $markup;
}
add_shortcode( 'careersform', 'careersform_func' );


// [cjedit id="1" detail="all"]
function cjedit_func( $atts ) {
	extract( shortcode_atts( array(
		'id' => '0',
		'detail' => 'all',
	), $atts ) );

	$id = "{$id}";
	$detail = "{$detail}";

	if (! $id) {
		return "No article specified.";
	}
	
	// This first chunk of PHP must go at the very top of the page.
	
	session_start();
	$postpass = $_POST['postpass'];
	
	if ( $postpass != "" )
		$_SESSION['cjviewpass'] = $postpass;
	
	// Insert the Page ID here:
	
	$printid = $id;
	
	// SQL information
	
	include("/usr/www/cjadvertising/cjadvertising.com/cjedit/config.php");
	
	// Display requested content.
	
	mysql_connect($sqlhost,$user,$password);
	@mysql_select_db($db) or die("Could not select database: " + $db);
	$query = "SELECT * FROM pages WHERE id='$id'";
	$result = mysql_query($query);
	$num = mysql_numrows($result);
	$i = 0;
	
	if ($num) {
		while ($i < $num) {
			$article = array();
			$article['title'] = (mb_convert_encoding(mysql_result($result,$i,"title"), 'HTML-ENTITIES', 'ISO-8859-1'));
			$article['subtitle'] = (mb_convert_encoding(mysql_result($result,$i,"subtitle"), 'HTML-ENTITIES', 'ISO-8859-1'));
			$article['content'] = (mb_convert_encoding(mysql_result($result,$i,"content"), 'HTML-ENTITIES', 'ISO-8859-1'));
			$article['password'] = (mb_convert_encoding(mysql_result($result,$i,"password"), 'HTML-ENTITIES', 'ISO-8859-1'));
			$i = $i + 1;
		}

		switch ($detail) {   
		    case 'title':
		        return $article['title'];
		        break;
		    case 'subtitle':
		        return $article['subtitle'];
		        break;
		    case 'content':
		        return $article['content'];
		        break;
		    case 'password':
		        return $article['password'];
		        break;
   		    case 'all':
		    default:
		    	$content = "";
		    	if ($article['title'] != "")
			    	$content .= "<h2>".$article['title']."</h2>";
		    	if ($article['subtitle'] != "")
		    		$content .= "<h3>".$article['subtitle']."</h3>";
		    	$content .= $article['content'];
		    	return $content;
		}
	}

	else {
		return "Invalid article specified.";
	}
}
add_shortcode( 'cjedit', 'cjedit_func' );