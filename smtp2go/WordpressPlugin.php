<?php
namespace SMTP2GO;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.smtp2go.com
 * @since      1.0.1
 *
 * @package    SMTP2GO\WordpressPlugin
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    SMTP2GO\WordpressPlugin
 * @author     SMTP2GO <ticket@smtp2go.com>
 */
class WordpressPlugin
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.1
     * @access   protected
     * @var      \SMTP2GO\WordpressPluginLoader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.1
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.1
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.1
     */
    public function __construct()
    {
        if (defined('SMTP2GO_WORDPRESS_PLUGIN_VERSION')) {
            $this->version = SMTP2GO_WORDPRESS_PLUGIN_VERSION;
        } else {
            $this->version = '1.0.2';
        }
        //this HAS to be lowercase
        $this->plugin_name = 'smtp2go-wordpress-plugin';

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - SMTP2GO\WordpressPlugin_Loader. Orchestrates the hooks of the plugin.
     * - SMTP2GO\WordpressPlugin_i18n. Defines internationalization functionality.
     * - SMTP2GO\WordpressPlugin_Admin. Defines all hooks for the admin area.
     * - SMTP2GO\WordpressPlugin_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.1
     * @access   private
     */
    private function loadDependencies()
    {
        $this->loader = new WordpressPluginLoader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the SMTP2GO\WordpressPlugin_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.1
     * @access   private
     */
    private function setLocale()
    {
        $plugin_i18n = new WordpressPlugini18n();

        $this->loader->addAction('plugins_loaded', $plugin_i18n, 'loadPluginTextdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.1
     * @access   private
     */
    private function defineAdminHooks()
    {
        $plugin_admin = new WordpressPluginAdmin($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('admin_menu', $plugin_admin, 'addMenuPage');

        $this->loader->addFilter('plugin_action_links_' . SMTP2GO_PLUGIN_BASENAME, $plugin_admin, 'addSettingsLink');

        $this->loader->addAction('admin_init', $plugin_admin, 'registerSettings');

        $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueueScripts');

        $this->loader->addAction('wp_ajax_smtp2go_send_email', $plugin_admin, 'sendTestEmail');
    }

    private function definePublicHooks()
    {
        $this->loader->addFilter('wp_mail', $this, 'initMailer');
    }

    /**
     * wp_mail filter handler
     *
     * @param array $args - to,from,body,headers,attachments
     * @return void
     */
    public function initMailer($args)
    {
        global $phpmailer;
        if (!$phpmailer instanceof SMTP2GOMailer) {
            $phpmailer          = new SMTP2GOMailer;
            $phpmailer->wp_args = $args;
        } else {
            $phpmailer->wp_args = $args;
        }
        //test purposes
        //$phpmailer->setSenderInstance(new CurlSender);

    }
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.1
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.1
     * @return    string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.1
     * @return    \SMTP2GO\WordpressPluginLoader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.1
     * @return    string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}
