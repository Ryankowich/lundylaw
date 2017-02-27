<?php

Carbon_Container::factory('theme_options', 'Theme Options')
	->add_fields(array(
		Carbon_Field::factory('separator', 'header_settings'),
		Carbon_Field::factory('attachment', 'slogan_image')
			->set_help_text( 'Recommended image size is 446px * 61px. Larger or smaller images will be resized.' ),
		Carbon_Field::factory('attachment', 'header_image')
			->set_help_text( 'Recommended image size is 490px * 61px. Larger or smaller images will be resized.' ),
		Carbon_Field::factory('text', 'chat_button_text')
			->set_default_value( 'Live Chat' ),
		Carbon_Field::factory('text', 'chat_button_link'),

		Carbon_Field::factory('attachment', 'default_header_image')
			->set_help_text( 'Recommended image size is 960px * 277px. Larger or smaller images will be resized.' ),

		Carbon_Field::factory('separator', 'footer_settings'),
		Carbon_Field::factory('text', 'location_section_title')
			->set_default_value( 'Our Locations' ),
		Carbon_Field::factory('complex', 'locations')
			->setup_labels(array(
				'singular_name' => 'Location',
				'plural_name'	=> 'Locations'
			))
			->add_fields(array(
				Carbon_Field::factory('text', 'location_title')
					->set_required( true ),
				Carbon_Field::factory('map_with_address', 'map'),
				Carbon_Field::factory('rich_text', 'address'),
				Carbon_Field::factory('text', 'directions_link'),
			)),

		Carbon_Field::factory('text', 'social_section_title')
			->set_default_value( 'Connect with us' ),
		Carbon_Field::factory('complex', 'social_icons')
			->setup_labels(array(
				'singular_name' => 'Icon',
				'plural_name'	=> 'Icons'
			))
			->set_max( 4 )
			->add_fields(array(
				Carbon_Field::factory('attachment', 'icon' )
					->set_required( true )
					->set_help_text( 'Recommended image size is 69px * 69px. Larger or smaller images will be resized.' ),
				Carbon_Field::factory('text', 'link')
					->set_required( true ),
			)),
		Carbon_Field::factory('complex', 'additional_link', 'Additional Links')
			->set_max( 3 )
			->setup_labels(array(
				'singular_name' => 'Link',
				'plural_name'	=> 'Links'
			))
			->add_fields(array(
				Carbon_Field::factory('attachment', 'icon')
					->set_help_text( 'Recommended image width is 64px. Wider image will be resized.' ),
				Carbon_Field::factory('text', 'link_text'),
				Carbon_Field::factory('text', 'link')
					->set_required( true ),
			)),

		Carbon_Field::factory('rich_text', 'copyright'),


		Carbon_Field::factory('separator', 'misc'),
		Carbon_Field::factory('header_scripts', 'header_script'),
		Carbon_Field::factory('footer_scripts', 'footer_script'),
	));

if ( carbon_twitter_widget_registered() ) {
	Carbon_Container::factory('theme_options', 'Twitter Settings')
		->set_page_parent('Theme Options')
		->add_fields(array(
			Carbon_Field::factory('html', 'twitter_settings_html')
				->set_html('
					<div style="position: relative; margin-left: -230px; background: #eee; border: 1px solid #ccc; padding: 10px;">
						<p><strong>Twitter API requires a Twitter application for communication with 3rd party sites. Here are the steps for creating and setting up a Twitter application:</strong></p>
						<ol>
							<li>Go to <a href="https://dev.twitter.com/apps/new" target="_blank">https://dev.twitter.com/apps/new</a> and log in, if necessary</li>
							<li>Supply the necessary required fields, accept the Terms of Service, and solve the CAPTCHA. Callback URL field may be left empty</li>
							<li>Submit the form</li>
							<li>On the next screen scroll down to <strong>Your access token</strong> section and click the <strong>Create my access token</strong> button</li>
							<li>Copy the following fields: Access token, Access token secret, Consumer key, Consumer secret to the below fields</li>
						</ol>
					</div>
				'),
			Carbon_Field::factory('text', 'twitter_oauth_access_token')
				->set_default_value(''),
			Carbon_Field::factory('text', 'twitter_oauth_access_token_secret')
				->set_default_value(''),
			Carbon_Field::factory('text', 'twitter_consumer_key')
				->set_default_value(''),
			Carbon_Field::factory('text', 'twitter_consumer_secret')
				->set_default_value(''),
		));
}