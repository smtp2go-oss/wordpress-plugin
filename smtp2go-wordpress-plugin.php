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
 * @package           SMTP2GO_Wordpress_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       SMTP2GO wordpress plugin
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

use Smtp2Go\WordpressPluginActivator;
use Smtp2Go\WordpressPluginDeactivator;

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

define('SMTP2GO_PLUGIN_BASENAME', plugin_basename(__FILE__));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smtp2go-wordpress-plugin-activator.php
 */
function activate_smtp2go_wordpress_plugin()
{
    WordpressPluginActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smtp2go-wordpress-plugin-deactivator.php
 */
function deactivate_smtp2go_wordpress_plugin()
{
    WordpressPluginDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_smtp2go_wordpress_plugin');
register_deactivation_hook(__FILE__, 'deactivate_smtp2go_wordpress_plugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

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
    $plugin = new Smtp2Go\WordpressPlugin();
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

//if the plugin isn't activated, this function will exist
if (!function_exists('wp_mail')) {
    function wp_mail($to, $subject, $message, $headers = '', $attachments = array())
    {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log(print_r($headers, 1));
            error_log('!!!!Attachments!!!!');
            error_log(print_r($attachments, 1));

        }
        //let other plugins modify the arguments as the native wp mail does
        $atts = apply_filters('wp_mail', compact('to', 'subject', 'message', 'headers', 'attachments'));

        if (isset($atts['to'])) {
            $to = $atts['to'];
        }

        if (!is_array($to)) {
            $to = explode(',', $to);
        }

        if (isset($atts['subject'])) {
            $subject = $atts['subject'];
        }

        if (isset($atts['message'])) {
            $message = $atts['message'];
        }

        if (isset($atts['headers'])) {
            $headers = $atts['headers'];
        }

        if (isset($atts['attachments'])) {
            $attachments = $atts['attachments'];
        }


        $smtp2gomessage = new Smtp2Go\ApiMessage($to, $subject, $message, $headers, $attachments);

        $smtp2gomessage->initFromOptions();

        $request = new Smtp2Go\ApiRequest;

        $request->send($smtp2gomessage);
    }
}

if (!function_exists('smtp2go_dd')) {
    function smtp2go_dd()
    {
        foreach (func_get_args() as $arg) {
            echo '<pre>', print_r($arg, 1), '</pre>';
        }
        exit;
    }
}

require_once dirname(__FILE__) . '/smtp2go-class-loader.php';

run_smtp2go_wordpress_plugin();
