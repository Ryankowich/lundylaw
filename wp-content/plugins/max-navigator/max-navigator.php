<?php
/*
Plugin Name: Max Navigator
Plugin URI: http://cjadvertising.com
Description: Max Navigator
Version: 0.1
Author: Greg Thornton
Author URI: http://xdissent.com
License: All rights reserved
*/

add_action('plugins_loaded', array('MaxNav', 'load'));

class MaxNav {
  public static function load() {
    require_once plugin_dir_path(__FILE__) . 'include/widget.php';
    MaxNavWidget::load();

    require_once plugin_dir_path(__FILE__) . 'include/shortcodes.php';
    MaxNavShortcodes::load();

    if (is_admin()) {
      require_once plugin_dir_path(__FILE__) . 'include/admin.php';
      MaxNavAdmin::load();
    }
  }
}