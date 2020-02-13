<?php
namespace SMTP2GO;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://thefold.nz
 * @since      1.0.0
 *
 * @package    SMTP2GO\WordpressPlugin

 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    SMTP2GO\WordpressPlugin
 * @author     The Fold <hello@thefold.co.nz>
 */
class WordpressPlugini18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
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
