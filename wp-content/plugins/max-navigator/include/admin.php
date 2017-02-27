<?php

class MaxNavAdmin {
  public static function load() {
    add_action('init', array(__CLASS__, 'init'));
  }

  public static function init() {
    add_action('save_post', array(__CLASS__, 'update_page_menu'));
    add_action('add_meta_boxes', array(__CLASS__, 'add_meta_box'));
  }

  public static function add_meta_box($post_type) {
    if ($post_type != 'page' || !post_type_supports($post_type, 'custom-fields')) {
      return;
    }
    add_meta_box('max-nav-meta-box', 'Max Navigator', array(__CLASS__, 'meta_box'), $post_type, 'side', 'default');
  }

  public static function meta_box($page) {
    echo self::menu_dropdown($page->ID);
  }

  public static function menu_dropdown($page_id) {
    $current = get_post_meta($page_id, 'max-nav-menu', true);
    $select = '<label>Menu:</label><select name="max-nav-menu">';
    $select .= '<option value="-1">(none)</option>';
    foreach (get_terms('nav_menu') as $menu) {
      $selected = $menu->term_id == $current ? 'selected="selected"' : '';
      $select .= '<option value="' . $menu->term_id . '"' . $selected . '>' . $menu->name . '</option>';
    }
    $select .= '</select><br />';
    $title = '<label>Title:</label><input type="text" name="max-nav-title" value="' . get_post_meta($page_id, 'max-nav-title', true) . '" /><br />';
    $url = '<label>Link:</label><input type="text" name="max-nav-url" value="' . get_post_meta($page_id, 'max-nav-url', true) . '" />';
    return $select . $title . $url;
  }

  public static function update_page_menu($page_id = null) {
    if (empty($page_id) || wp_is_post_revision($page_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
      return $page_id;
    }
    $menu = $_REQUEST['max-nav-menu'];
    if (empty($menu) || $menu == '-1') {
      delete_post_meta($page_id, 'max-nav-menu');
    } else {
      update_post_meta($page_id, 'max-nav-menu', $menu);
    }
    $title = $_REQUEST['max-nav-title'];
    if (empty($title)) {
      delete_post_meta($page_id, 'max-nav-title');
    } else {
      update_post_meta($page_id, 'max-nav-title', $title);
    }
    $url = $_REQUEST['max-nav-url'];
    if (empty($url)) {
      delete_post_meta($page_id, 'max-nav-url');
    } else {
      update_post_meta($page_id, 'max-nav-url', $url);
    }
  }
}