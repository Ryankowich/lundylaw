<?php

class MaxNavShortcodes {
  public static function load() {
    add_action('init', array(__CLASS__, 'init'));
  }

  public static function init() {
    add_shortcode('breadcrumbs', array(__CLASS__, 'breadcrumbs'));
    add_shortcode('nav', array(__CLASS__, 'nav'));
  }

  public static function nav($atts) {
    $defaults = array('title' => '');
    extract(shortcode_atts($defaults, $atts));
    ob_start();
    the_widget('MaxNavWidget', array('title' => $title));
    return ob_get_clean();
  }

  public static function breadcrumbs($atts) {
    $defaults = array('separator' => ' / ', 'home' => true);
    extract(shortcode_atts($defaults, $atts));

    $page = get_queried_object();
    if (empty($page) || $page->post_type != 'page') return;

    $parents = array_reverse(get_post_ancestors($page->ID));

    if ($home) {
      $home_id = get_option('page_on_front');
      if (empty($home_id)) $home_id = 0;
      if (!in_array($home_id, $parents)) array_unshift($parents, $home_id);
    }

    return implode($separator, array_map(array(__CLASS__, 'breadcrumb'), $parents));
  }

  public static function breadcrumb($page_id) {
    if ($page_id == 0) {
      $url = get_bloginfo('url');
      $title = 'Home';
    } else {
      $url = get_permalink($page_id);
      $title = get_the_title($page_id);
    }
    return '<a href="' . $url . '">' . $title . '</a>';
  }
}