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
		<form action="http://www.cjadvertising.com/forms/submit.php" method="post" class="clearfix">
			<input type="hidden" name="title" value="Lundy Law | Quick Contact Form" />
		    <input type="hidden" name="formuser" value="llw" />
			<div class="form-slogan">
				<h3>Get Help Today</h3>
				<p>Fill out this form to receive a<br /> free initial consultation.</p>
			</div>

			<label>NAME:</label>
			<input type="text" class="field required" name="name" title="Your Name" value="" placeholder="First, Last"/>

			<label>Phone:</label>
			<input type="text" class="field required phone-number" title="Phone Number" name="phone" value="" placeholder="xxx-xxx-xxxx"/>

			<label>Email:</label>
			<input type="text" class="field required email-address" name="email" title="Email Address" value="" placeholder="name@email.com"/>

			<label>Message:</label>
			<textarea class="textarea" name="message required" title="Message" placeholder="How can we help you?"></textarea>

			<input type="submit" class="submit-btn" value="submit form" />
		</form>
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