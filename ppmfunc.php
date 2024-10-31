<?php
/*
Plugin Name: Posts per Month
Plugin URI: http://wordpress.org/extend/plugins/posts-per-month/
Description: Visualizes the number of posts per month
Version: 1.4.2
Author: Van Tien Bui
Author URI: http://tienbui.de
License: GPL2
*/


if ( is_admin() ) {
  load_plugin_textdomain('ppm', false, basename( dirname( __FILE__ ) ) . '/languages/' );

  add_action( 'wp_dashboard_setup', 'add_dashboard_ppm');

  function dashboard_output_ppm() {
    require plugin_dir_path(__FILE__).'magic.php';
  }

  function add_dashboard_ppm() {
    wp_add_dashboard_widget( 'dashboard_posts_per_month', __('Posts per Month', 'ppm'), 'dashboard_output_ppm', 'widget_control_ppm' );
  }

  function widget_control_ppm() {
    $widget_id = 'dashboard_posts_per_month';
    $form_id = 'control_post_per_month';


    if ( !$widget_options = get_option( 'dashboard_widget_options' ) )
      $widget_options = array();

    if ( !isset($widget_options[$widget_id]) )
      $widget_options[$widget_id] = array();

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST[$form_id]) ) {
      $limit = absint( $_POST[$form_id]['items'] );

    if($limit==0) $limit=1;
      $widget_options[$widget_id]['items'] = $limit;
      update_option( 'dashboard_widget_options', $widget_options );
    }

    $limit = isset( $widget_options[$widget_id]['items'] ) ? (int) $widget_options[$widget_id]['items'] : 15;

    echo '<p><label for="post-per-month-number">' . __('Number of months to display:', 'ppm') . '</label>';
    echo '<input id="post-per-months-number" name="'.$form_id.'[items]" type="text" value="' . $limit . '" size="3" /></p>';
  }
}
?>