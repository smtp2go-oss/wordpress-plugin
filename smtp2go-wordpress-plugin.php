<?php
/**
 * The plugin bootstrap file - the filename MUST be all lowercase
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.smtp2go.com
 * @since             1.0.1
 * @package           SMTP2GO\WordpressPlugin
 *
 * @wordpress-plugin
 * Plugin Name:       SMTP2GO - Email Made Easy
 * Plugin URI:        https://github.com/thefold/smtp2go-wordpress-plugin
 * Description:       Send all email from WordPress via SMTP2GO. Scalable, reliable email delivery. https://www.smtp2go.com/.
 * Version:           1.10.0
 * Author:            SMTP2GO
 * Author URI:        https://www.smtp2go.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       SMTP2GO-wordpress-plugin
 * Domain Path:       /languages
 */

use SMTP2GO\App\WordpressPluginActivator;
use SMTP2GO\App\WordpressPluginDeactivator;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SMTP2GO_WORDPRESS_PLUGIN_VERSION', '1.10.0');

define('SMTP2GO_PLUGIN_BASENAME', plugin_basename(__FILE__));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-SMTP2GO-wordpress-plugin-activator.php
 */
function activate_SMTP2GO_wordpress_plugin()
{
    WordpressPluginActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-SMTP2GO-wordpress-plugin-deactivator.php
 */
function deactivate_SMTP2GO_wordpress_plugin()
{
    WordpressPluginDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_SMTP2GO_wordpress_plugin');
register_deactivation_hook(__FILE__, 'deactivate_SMTP2GO_wordpress_plugin');

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
 * @since    1.0.1
 */
function run_SMTP2GO_wordpress_plugin()
{
    $plugin = new SMTP2GO\App\WordpressPlugin();
    $plugin->run();
}

if (!function_exists('SMTP2GO_dd')) {
    function SMTP2GO_dd()
    {
        foreach (func_get_args() as $arg) {
            echo '<pre>', print_r($arg, 1), '</pre>';
        }

        $e = new Exception;
        echo '<pre>', print_r($e->getTraceAsString(), 1), '</pre>';

        exit;
    }
}

require_once dirname(__FILE__) . '/smtp2go-class-loader.php';

run_SMTP2GO_wordpress_plugin();
