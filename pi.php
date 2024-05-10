<?php

/**
 * Plugin Insights
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Insights
 * Description:       Gain detailed insights into your WordPress plugins beyond what WordPress provides. Explore version numbers, authors, descriptions, and compatibility details effortlessly with Plugin Insights.
 * Version:           0.1.0
 * Author:            CallMeLeon
 * Requires PHP:      7.0
 * Requires at least: 6.5
 */

if (!defined('ABSPATH')) die('No direct access allowed');

define('PI_DIR', dirname(__FILE__));
define('PI_URL', plugins_url('', __FILE__));
define('PI_PLUGIN_SLUG', plugin_basename(__FILE__));

include_once PI_DIR . '/options.php';
include_once PI_DIR . '/template/site.php';

add_action('admin_menu', function () {
    add_plugins_page(
        'Plugin Insights',
        'Plugin Insights',
        'manage_options',
        'plugin-insights',
        'pi_render_site'
    );
});

add_action('admin_enqueue_scripts', function () {
    $css_url = PI_URL . '/assets/css/plugin-insights-style.css';
    wp_enqueue_style('plugin-insights-style', $css_url);

    $js_url = PI_URL . '/assets/js/plugin-insights-script.js';
    wp_enqueue_script('plugin-insights-script', $js_url);
});
