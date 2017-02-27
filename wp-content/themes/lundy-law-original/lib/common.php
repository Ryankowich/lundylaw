<?php
include_once(dirname(__FILE__) . '/twitter/TwitterHelper.php');
include_once(dirname(__FILE__) . '/video-functions.php');
include_once(dirname(__FILE__) . '/user-functions.php');
include_once(dirname(__FILE__) . '/comments.php');

/**
 * Truncates a string to a certain word count.
 * @param  string  $input Text to be shortalized. Any HTML will be stripped.
 * @param  integer $words_limit number of words to return
 * @param  string $end the suffix of the shortalized text
 * @return string
 */
function crb_shortalize($input, $words_limit=15, $end='...') {
	$input = strip_tags($input);
	$words_limit = abs(intval($words_limit));

	if ($words_limit == 0) {
		return $input;
	}

	$words = str_word_count($input, 2, '0123456789');
	if (count($words) <= $words_limit + 1) {
		return $input;
	}
	
	$loop_counter = 0;
	foreach ($words as $word_position => $word) {
		$loop_counter++;
		if ($loop_counter==$words_limit + 1) {
			return substr($input, 0, $word_position) . $end;
		}
	}
}

/**
 * Crawls the taxonomy tree up to top level taxonomy ancestor and returns
 * that taxonomy as object. 
 * @param  int $term_id
 * @param  string $taxonomy Taxonomy slug
 * @return mixed object with the ancestor or false if the term or taxonomy don't exist
 */
function crb_taxonomy_ancestor($term_id, $taxonomy) {
	$term_obj = get_term_by('id', $term_id, $taxonomy);
	while ($term_obj->parent!=0) {
		$term_obj = get_term_by('id', $term_obj->parent, $taxonomy);
	}
	return get_term_by('id', $term_obj->term_id, $taxonomy);
}

/**
 * Shortcut for get_post_meta. 
 * @param  string $key 
 * @param  integer $id required if the function is not called in loop context
 * @return string custom field if it exist
 */
function crb_get_meta($key, $id=null) {
	if (!isset($id)) {
		global $post;
		if (empty($post->ID)) {
			return null;
		}
		$id = $post->ID;
	}
	return get_post_meta($id, $key, true);
}

/**
 * Gets all pages / posts which have the specified custom field. Does not check
 * whether it has any value - just for existence. 
 * @param  string $meta_key
 * @return array
 */
function crb_get_content_by_meta_key($meta_key) {
	global $wpdb;
	$result = $wpdb->get_col('
		SELECT DISTINCT(post_id)
		FROM ' . $wpdb->postmeta . '
		WHERE meta_key = "' . $meta_key . '"
	');
	if(empty($result)) {
		return array();
	}
	return $result;
}
