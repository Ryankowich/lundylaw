<?php

Carbon_Container::factory('custom_fields', __('Title Settings', 'll'))
	->show_on_post_type('page')
	->add_fields( array(
		Carbon_Field::factory('text', 'custom_title')
		
		/*
		// REMOVED AND REPLACED WITH MAX NAVIGATOR
		Carbon_Field::factory("choose_sidebar", "custom_sidebar", "Sidebar")
			->help_text('Select which sidebar to show in this page, or click "Add New" to create a new one')
			->set_sidebar_options( crb_widgets_defaults() )
		*/
	));
	
# Attorney Detail Fields
Carbon_Container::factory('custom_fields', __('Attorney Details', 'll'))
	->show_on_post_type('page')
	->show_on_template('template-attorney.php')
	->add_fields(array(
		Carbon_Field::factory('text', 'attorney_name')
			->set_required(true)
			->help_text('The displayed name for this attorney'),
		Carbon_Field::factory("image", "attorney_photo", "Photo")
			->set_required(true)
			->help_text('Select a photo for this attorney (displayed on the attorney overview page). Dimensions should be 280px * 330px.'),
		Carbon_Field::factory('text', 'attorney_email')
			->help_text('Provide an email for this attorney'),
		Carbon_Field::factory('text', 'attorney_phone')
			->help_text('Provide a phone number for this attorney'),
		Carbon_Field::factory('textarea', 'attorney_quote')
			->help_text('Provide an optional quote for this attorney\'s profile')
	));

# Homepage Fields
Carbon_Container::factory('custom_fields', __('Homepage Settings', 'll'))
	->show_on_post_type('page')
	->show_on_template('template-home.php')
	->add_fields(array(
		Carbon_Field::factory('complex', 'awards')
			->setup_labels(array(
				'singular_name' => 'Award',
				'plural_name'	=> 'Awards'
			))
			->add_fields(array(
				Carbon_Field::factory('attachment', 'award')
					->set_help_text( 'Recommeded image size is 178px * 159px. Larger or smaller images will be resized.' ),
			)),
	));

# Homepage Content Fields
Carbon_Container::factory('custom_fields', __('Homepage Content Settings', 'll' ))
	->show_on_post_type('page')
	->show_on_template('template-home.php')
	->add_fields( array(
		Carbon_Field::factory('complex', 'content_sections')
			->setup_labels(array(
				'singular_name' => 'Section',
				'plural_name'	=> 'Sections'
			))
			->add_fields( 'video_section', ll_crb_home_fields( 3 ) )
			->add_fields( 'faq_section', ll_crb_home_fields( 8 ) )
			->add_fields( 'content_section', array(
				Carbon_Field::factory('text', 'section_title'),
				Carbon_Field::factory('rich_text', 'content'),
				Carbon_Field::factory('text', 'button_text'),
				Carbon_Field::factory('text', 'button_link'),
				Carbon_Field::factory('attachment', 'background_image')
					->set_help_text( 'Recommended image size is 960px * 304px. Larger or smaller images will be resized.' ),
			)),

	));

# Video Fields


// modified to use Brightcove

Carbon_Container::factory('custom_fields', __( 'Video Settings', 'll' ))
	->show_on_post_type( 'video' )
	->add_fields(array(
		Carbon_Field::factory('text', 'video_url')
			->set_help_text( 'YouTube and Vimeo supperted' ),
		Carbon_Field::factory('attachment', 'video_thumb')
			->set_help_text( 'Recommended image size is 306px * 172px. Larger or smaller images will be resized.' ),
	));
	
/*

Carbon_Container::factory('custom_fields', __( 'Video Settings', 'll' ))
	->show_on_post_type( 'video' )
	->add_fields(array(
		Carbon_Field::factory('text', 'video_id')
			->set_help_text( 'Brightcove @videoPlayer Parameter' )
			->set_required(true),
		Carbon_Field::factory('text', 'video_player')
			->set_help_text( 'Brightcove playerID Parameter (optional)' ),
		Carbon_Field::factory('text', 'video_key')
			->set_help_text( 'Brightcove playerKey Parameter (optional)' ),
		Carbon_Field::factory('attachment', 'video_thumb')
			->set_help_text( 'Recommended image size is 306px * 172px. Larger or smaller images will be resized.' ),
	));*/
