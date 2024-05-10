<?php

if (!defined('ABSPATH')) die('No direct access allowed');

function pi_get_plugin_info()
{
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $all_plugins = get_plugins();

    $active_plugins = get_option('active_plugins');

    foreach ($all_plugins as $key => $value) {
        $is_active = (in_array($key, $active_plugins)) ? "Yes" : "No";
        $all_plugins[$key]['Active'] = $is_active;

        unset($all_plugins[$key]['Description']);
        unset($all_plugins[$key]['Author']);
        unset($all_plugins[$key]['AuthorURI']);
        unset($all_plugins[$key]['TextDomain']);
        unset($all_plugins[$key]['DomainPath']);
        unset($all_plugins[$key]['Network']);
        unset($all_plugins[$key]['UpdateURI']);
        unset($all_plugins[$key]['RequiresPlugins']);

        $update_plugins = get_site_transient('update_plugins');
        if (isset($update_plugins->response[$key])) {
            $new_version = $update_plugins->response[$key]->new_version;
            $all_plugins[$key]['UpdateAvailable'] = $new_version;
        } else {
            $all_plugins[$key]['UpdateAvailable'] = false;
        }

        $plugin_slug = dirname($key);
        $all_plugins[$key]['Slug'] = $plugin_slug;
        $response = wp_remote_get('https://api.wordpress.org/plugins/info/1.0/' . $plugin_slug . '.json');

        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $plugin_info = json_decode($body, true);

            if (isset($plugin_info['error'])) {
                $all_plugins[$key]['InStore'] = false;
            } else {
                $all_plugins[$key]['InStore'] = true;
            }

            if (isset($plugin_info['rating'])) {
                $all_plugins[$key]['Rating'] = $plugin_info['rating'] . "%";
            } else {
                $all_plugins[$key]['Rating'] = "No data";
            }

            if (isset($plugin_info['last_updated'])) {
                $last_updated = strtotime($plugin_info['last_updated']);
                $time_diff = human_time_diff($last_updated, current_time('timestamp')) . ' ago';
                $all_plugins[$key]['LastUpdated'] = $time_diff;
            } else {
                $all_plugins[$key]['LastUpdated'] = 'Unknown';
            }
        }
    }

    return $all_plugins;
}
