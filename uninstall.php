<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.smtp2go.com
 * @since      1.0.1
 *
 * @package    SMTP2GO\WordpressPlugin
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
if (is_multisite() && !wp_is_large_network()) {
    foreach (get_sites() as $site) {
        switch_to_blog($site->blog_id);
        smtp2go_delete_options();
    }
    restore_current_blog();
} else {
    smtp2go_delete_options();
}

function smtp2go_delete_options()
{
    foreach (['smtp2go_api_key',
        'smtp2go_custom_headers',
        'smtp2go_enabled',
        'smtp2go_from_address',
        'smtp2go_from_name'] as $option_name) {
        delete_option($option_name);
    }
}
