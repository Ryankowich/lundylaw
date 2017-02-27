<?php

class MaxNavWidget extends WP_Widget {
  public static function load() {
    add_action('widgets_init', array(__CLASS__, 'init'));
  }

  public static function init() {
    register_widget(__CLASS__);
  }

  function __construct() {
    $widget_ops = array('description' => 'A smart navigation sidebar widget');
    $this->WP_Widget('max_nav', 'Max Navigator Widget', $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    $page = get_queried_object();
    if ($page->post_type != 'page') return;
    $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
    echo $before_widget;
    echo ( empty( $title ) ) ? '' : $before_title . $title . $after_title;
    echo $this->nav($page->ID);
    echo $after_widget;
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = wp_strip_all_tags($new_instance['title']);
    return $instance;
  }

  function form($instance) {
    $instance = wp_parse_args((array)$instance, array('title' => ''));
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat">
    </p>
    <?php
  }

  function nav($page_id) {
    $menu_id = get_post_meta($page_id, 'max-nav-menu', true);
    if ($menu_id) {
      $menu = wp_nav_menu(array('menu' => $menu_id, 'echo' => false));
      if ($menu) {
        $title = get_post_meta($page_id, 'max-nav-title', true);
        if (empty($title)) {
          $term = get_term($menu_id, 'nav_menu');
          $title = $term->name;
        }
        if (empty($title)) {
          $header = $this->navHeader($page_id);
        } else {
          $url = get_post_meta($page_id, 'max-nav-url', true);
          if (!empty($url)) {
            $title = '<a href="' . $url . '">' . $title . '</a>';
          }
          //$header = '<h3>' . $title . '</h3>';
          $header = '<h4 class="widgettitle">' . $title . '</h4>';
        }
        return $header . $menu;
      }
    }

    $args = array('child_of' => $page_id, 'depth' => 1, 'title_li' => '', 'echo' => false);
    $menu = wp_list_pages($args);
    if ($menu) {
      $menu = '<div class="menu-container"><ul class="menu">' . $menu . '</ul></div>';
      return $this->navHeader($page_id) . $menu;
    }

    $parents = get_post_ancestors($page_id);
    if (empty($parents)) $parents = array(0);
    return $this->nav($parents[0]);
  }

  function navHeader($page_id) {
    // return '<h3><a href="' . get_permalink($page_id) . '">' . get_the_title($page_id) . '</a></h3>';
    return '<h4 class="widgettitle">' . get_the_title($page_id) . '</h4>';
  }
}