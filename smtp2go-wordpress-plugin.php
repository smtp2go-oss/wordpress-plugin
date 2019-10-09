<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thefold.nz
 * @since             1.0.0
 * @package           Smtp2go_Wordpress_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       smtp2go wordpress plugin
 * Plugin URI:        https://github.com/thefold/smtp2go-wordpress-plugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            The Fold
 * Author URI:        https://thefold.nz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smtp2go-wordpress-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SMTP2GO_WORDPRESS_PLUGIN_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smtp2go-wordpress-plugin-activator.php
 */
function activate_smtp2go_wordpress_plugin()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-smtp2go-wordpress-plugin-activator.php';
    Smtp2go_Wordpress_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smtp2go-wordpress-plugin-deactivator.php
 */
function deactivate_smtp2go_wordpress_plugin()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-smtp2go-wordpress-plugin-deactivator.php';
    Smtp2go_Wordpress_Plugin_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_smtp2go_wordpress_plugin');
register_deactivation_hook(__FILE__, 'deactivate_smtp2go_wordpress_plugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-smtp2go-wordpress-plugin.php';

require_once plugin_dir_path(__FILE__) . 'includes/class-smtp2go-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_smtp2go_wordpress_plugin()
{
    $plugin = new Smtp2goWordpressPlugin();
    $plugin->run();
}

/**
 * Override the built in wp_mail function so we can send via the smtp2go api
 *
 * @param string|array $to
 * @param string $subject
 * @param string $message
 * @param string|array $headers
 * @param string|array $attachments
 * @return bool
 */
if (!function_exists('wp_mail')) {
    function wp_mail($to, $subject, $message, $headers = '', $attachments = array())
    {
        $smtp2goapi = new Smtp2goApi($to, $subject, $message, $headers, $attachments);

        $smtp2goapi->initFromOptions();
        $smtp2goapi->send(new WP_Http);
    }
}
run_smtp2go_wordpress_plugin();
