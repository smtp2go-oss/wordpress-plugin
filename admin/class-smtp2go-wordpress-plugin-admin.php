<?php

    /**
     * The admin-specific functionality of the plugin.
     *
     * @link       https://thefold.nz
     * @since      1.0.0
     *
     * @package    Smtp2go_Wordpress_Plugin
     * @subpackage Smtp2go_Wordpress_Plugin/admin
     */

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Smtp2go_Wordpress_Plugin
     * @subpackage Smtp2go_Wordpress_Plugin/admin
     * @author     The Fold <hello@thefold.co.nz>
     */
class Smtp2goWordpressPluginAdmin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Save the options from the admin page
     * @since 1.0.0
     * @return void
     */
    public function updateOptions()
    {

        // status_header(200);
        // die("Server received '{$_POST['data']}' from your browser.");
        //request handlers should die() when they complete their task
        wp_redirect('/wp-admin/tools.php?page=' . $this->plugin_name);
    }

    public function registerSettings()
    {
        register_setting(
            'api_settings',
            'smtp2go_api_key'
        );
        add_settings_section(
            'smtp2go_settings_section',
            'SMTP2Go Settings Section',
            array($this, 'settingsSection'),
            $this->plugin_name
        );



        // register a new section in the "reading" page

 
        // register a new field in the "wporg_settings_section" section, inside the "reading" page
        add_settings_field(
            'smtp2go_api_key',
            __('API Key', $this->plugin_name),
            [$this, 'apiKeyField'],
            $this->plugin_name,
            'smtp2go_settings_section'
        );
    }

    public function settingsSection()
    {
        // echo '<h3>Settings</h3>';
    }

    public function apiKeyField($args)
    {
        // print_r($args);
        $setting = get_option('smtp2go_api_key');
        if (empty($setting)) {
            $setting = '';
        }
        echo '<input name="smtp2go_api_key" value="' . esc_attr($setting) . '"/> ';
    }

    public function addSubmenuPage()
    {
        add_menu_page(
            'SMTP2Go',
            'SMTP2Go',
            'manage_options',
            $this->plugin_name,
            [$this, 'renderManagementPage']
        );
    }

    public function renderManagementPage()
    {
        //fetch all the options
        
        //display the page
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/smtp2go-wordpress-plugin-admin-display.php';
    }
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Smtp2go_Wordpress_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Smtp2go_Wordpress_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smtp2go-wordpress-plugin-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Smtp2go_Wordpress_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Smtp2go_Wordpress_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smtp2go-wordpress-plugin-admin.js', array('jquery'), $this->version, false);

    }

}
