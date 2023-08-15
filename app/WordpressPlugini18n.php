<?php
namespace SMTP2GO\App;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.smtp2go.com
 * @since      1.0.1
 *
 * @package    SMTP2GO\WordpressPlugin

 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.1
 * @package    SMTP2GO\WordpressPlugin
 * @author     SMTP2GO <ticket@smtp2go.com>
 */
class WordpressPlugini18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.1
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain(
            'SMTP2GO-wordpress-plugin',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
