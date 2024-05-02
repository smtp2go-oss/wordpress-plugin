<?php

namespace SMTP2GO\App;

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

        add_filter('admin_footer_text', [$this, 'admin_footer']);

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
     * - SMTP2GO\App\WordpressPlugin_Loader. Orchestrates the hooks of the plugin.
     * - SMTP2GO\App\WordpressPlugin_i18n. Defines internationalization functionality.
     * - SMTP2GO\App\WordpressPlugin_Admin. Defines all hooks for the admin area.
     * - SMTP2GO\App\WordpressPlugin_Public. Defines all hooks for the public side of the site.
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
     * Uses the SMTP2GO\App\WordpressPlugin_i18n class in order to set the domain and to register the hook
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

        $this->loader->addAction('phpmailer_init', $this, 'configurePhpmailer');
    }

    public function configurePhpmailer($phpmailer)
    {
        if (!get_option('smtp2go_enabled')) {
            return;
        }
        //ensures that mail goes through our extended mailSend method

        /** @var \PHPMailer\PHPMailer\PHPMailer $phpmailer */
        $phpmailer->isMail();
    }

    private function definePublicHooks()
    {
        $this->loader->addFilter('wp_mail', $this, 'initMailer');
    }

    /**
     * wp_mail filter handler
     *
     * @param array $args - to,from,body,headers,attachments
     * @return array
     */
    public function initMailer($args)
    {
        global $phpmailer;

        if (!get_option('smtp2go_enabled') && !defined('SMTP2GO_TEST_MAIL')) {
            return $args;
        }

        if (!$phpmailer instanceof SMTP2GOMailer) {
            $phpmailer          = new SMTP2GOMailer;
            $phpmailer->wp_args = $args;
            if (defined('WP_HOME') && WP_HOME === 'http://localhost:8889') {
                $phpmailer->setApiClient(new \SMTP2GO\App\MockApiClient(get_option('smtp2go_api_key')));
            }
        } else {
            $phpmailer->wp_args = $args;
        }
        //need to return these for other users of the wp_mail filter
        return $args;
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

    /**
     * When user is on a SMTP2GO related admin page, display footer text
     * that graciously asks them to rate us.
     *
     * @since 1.5.0
     *
     * @param string $text Footer text.
     *
     * @return string
     */
    public function admin_footer($text = "")
    {

        global $current_screen;

        if (!empty($current_screen->id) && strpos($current_screen->id, 'smtp2go') !== false) {
            $url  = 'https://wordpress.org/support/plugin/smtp2go/reviews/?filter=5#new-post';

            $text = "Thank you for using the <strong>SMTP2GO plugin!</strong> Please leave us a 5 star review on <a href='$url' target='_blank'>Wordpress.org</a> to help spread the word.";
        }
        return $text;
    }
}
