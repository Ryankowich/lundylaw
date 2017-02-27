<?php
/**
 * Register the new widget classes here so that they show up in the widget list 
 */
function crb_load_widgets() {
	// register_widget('CrbLatestTweetsWidget');
	// register_widget('ThemeWidgetExample');
	register_widget('ContactFormWidget');
	register_widget('VideoWidget');
}
add_action('widgets_init', 'crb_load_widgets');

/**
 * Displays a block with latest tweets from particular user
 */
class CrbLatestTweetsWidget extends Carbon_Widget {
	protected $form_options = array(
		'width' => 300
	);

	function __construct() {
		$this->setup('Latest Tweets', 'Displays a block with your latest tweets', array(
			Carbon_Field::factory('text', 'title', 'Title'),
			Carbon_Field::factory('text', 'username', 'Username'),
			Carbon_Field::factory('text', 'count', 'Number of Tweets to show')->set_default_value('5')
		));
	}

	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		if ( !carbon_twitter_is_configured() ) {
			return; //twitter settings are not configured
		}

		$tweets = TwitterHelper::get_tweets($instance['username'], $instance['count']);
		if (empty($tweets)) {
			return; //no tweets, or error while retrieving
		}

		extract($args);
		if ($instance['title']) {
			echo $before_title . $instance['title'] . $after_title;
		}
		?>
		<ul>
			<?php foreach ($tweets as $tweet): ?>
				<li><?php echo $tweet->tweet_text ?> - <span><?php echo $tweet->time_distance ?> ago</span></li>
			<?php endforeach ?>
		</ul>
		<?php
	}
}

/**
 * Static Form Widget
 */
class ContactFormWidget extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Contact Form', 'Displays a contact form', array(
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);
		?>
		<form action="/thanks/#wpcf7-f5156-p4-o1" method="post" class="wpcf7-form" novalidate="novalidate">
			<div style="display: none;">
				<input type="hidden" name="_wpcf7" value="5156">
				<input type="hidden" name="_wpcf7_version" value="4.3.1">
				<input type="hidden" name="_wpcf7_locale" value="en_US">
				<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f5156-p4-o1">
				<input type="hidden" name="_wpnonce" value="776a6ae8af">
				<input type="hidden" name="title" value="Lundy Law | Quick Contact Form" />
			</div>			
			<div class="form-slogan">
				<h3>Get Help Today</h3>
				<p>Fill out this form to receive a<br /> free initial consultation.</p>
			</div>

			<label>NAME:</label>
			<input type="text" class="field required" name="your-name" title="Your Name" value="" placeholder="First, Last"/>

			<label>Phone:</label>
			<input type="text" class="field required phone-number" title="Phone Number" name="your-phone" value="" placeholder="xxx-xxx-xxxx"/>

			<label>Email:</label>
			<input type="text" class="field required email-address" name="your-email" title="Email Address" value="" placeholder="name@email.com"/>

			<label>Message:</label>
			<textarea class="textarea" name="your-message" title="Message" placeholder="How can we help you?"></textarea>
			
			<span class="wpcf7-form-control-wrap pooh-bear-wrap" style="display:none !important;visibility:hidden !important;"><input class="wpcf7-form-control wpcf7-text pooh-bear"  type="text" name="pooh-bear" value="" size="40" tabindex="-1" /><br><small>Please leave this field empty.</small></span>
			
			<input type="submit" class="submit-btn wpcf7-form-control wpcf7-submit" value="submit form" />
			<img src="http://lundylaw.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;">
			<img class="ajax-loader" src="http://lundylaw.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;">
		</form>
		<div class="wpcf7-response-output wpcf7-display-none"></div>
		<?php
	}
}

/**
 * An example widget
 */
class VideoWidget extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Video Widget', 'Displays a video', array(
			Carbon_Field::factory('text', 'video_url'),
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);
		
		if ( $instance['video_url'] ){
			echo create_embedcode( $instance['video_url'], 325, 183 );
		} 
	}
}

/**
 * An example widget
 */
class ThemeWidgetExample extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Theme Widget - Example', 'Displays a block with title/text', array(
			Carbon_Field::factory('text', 'title', 'Title')->set_default_value('Hello World!'),
			Carbon_Field::factory('textarea', 'text', 'Content')->set_default_value('Lorem Ipsum dolor sit amet')
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);
		if ($instance['title'] != '') {
			echo $before_title . $instance['title'] . $after_title;
		}
		?>
		<p><?php echo $instance['text'];?></p>
		<?php
	}
}