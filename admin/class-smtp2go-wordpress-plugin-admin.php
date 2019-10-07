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
    // public function updateOptions()
    // {
    //     wp_redirect('/wp-admin/tools.php?page=' . $this->plugin_name);
    // }

    /**
     * Register all settings fields for the admin page
     *
     * @since 1.0.0
     * @return void
     */
    public function registerSettings()
    {
        add_settings_section(
            'smtp2go_settings_section',
            'General',
            array($this, 'settingsSection'),
            $this->plugin_name
        );

        add_settings_section(
            'smtp2go_custom_headers_section',
            'Custom Headers',
            array($this, 'settingsSection'),
            $this->plugin_name
        );

        /** api key field */
        register_setting(
            'api_settings',
            'smtp2go_api_key',
            array($this, 'validateApiKey')
        );

        add_settings_field(
            'smtp2go_api_key',
            __('API Key *', $this->plugin_name),
            array($this, 'textField'),
            $this->plugin_name,
            'smtp2go_settings_section',
            array('name' => 'smtp2go_api_key', 'required' => true)
        );
        /** from email address field */

        register_setting(
            'api_settings',
            'smtp2go_from_address'
        );

        add_settings_field(
            'smtp2go_from_address',
            __('From Email Address *', $this->plugin_name),
            [$this, 'textField'],
            $this->plugin_name,
            'smtp2go_settings_section',
            array('name' => 'smtp2go_from_address', 'type' => 'email', 'required' => true)
        );

        register_setting(
            'api_settings',
            'smtp2go_from_name'
        );

        add_settings_field(
            'smtp2go_from_name',
            __('From Email Name *', $this->plugin_name),
            [$this, 'textField'],
            $this->plugin_name,
            'smtp2go_settings_section',
            array('name' => 'smtp2go_from_name', 'required' => true)
        );

        register_setting(
            'api_settings',
            'smtp2go_custom_headers'
        );

        add_settings_field(
            'smtp2go_custom_headers',
            __('&nbsp;', $this->plugin_name),
            [$this, 'customHeaders'],
            $this->plugin_name,
            'smtp2go_custom_headers_section',
            array()
        );
    }

    /**
     * Output the html for managing custom headers
     *
     * @return void
     */
    public function customHeaders()
    {
        $custom_headers = get_option('smtp2go_custom_headers');
        $existing_fields = '';
        if (!empty($custom_headers['header'])) {
            foreach ($custom_headers['header'] as $index => $existing_custom_header) {
                $existing_fields .=
                    '<tr>'
                    . '<td><input type="text" name="smtp2go_custom_headers[header][]" value="' . $existing_custom_header . '"/></td>'
                    . '<td><input type="text" name="smtp2go_custom_headers[value][]" value="' . $custom_headers['value'][$index] . '"/></td>'
                    . '</tr>';
            }
        }

        echo '<table class="smtp2go_custom_headers">'
            . '<tr>'
            . '<th>Header</th>'
            . '<th>Value</th>'
            . $existing_fields
            . '<tr>'
            . '<td><input type="text" name="smtp2go_custom_headers[header][]"/></td>'
            . '<td><input type="text" name="smtp2go_custom_headers[value][]"/></td>'
            . '</tr>';
    }

    public function settingsSection()
    {
    }

    public function textField($args)
    {
        $field_name = $args['name'];

        $setting = get_option($field_name);

        if (empty($setting)) {
            $setting = '';
        }
        $required = '';
        if (!empty($args['required'])) {
            $required = 'required="required"';
        }

        $type = 'text';
        if (!empty($args['type'])) {
            $type = $args['type'];
        }
        echo '<input type="' . $type . '"' . $required . ' class="smtp2go_text_input" name="' . $field_name . '" value="' . esc_attr($setting) . '"/> ';
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smtp2go-wordpress-plugin-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smtp2go-wordpress-plugin-admin.js', array('jquery'), $this->version, false);
    }

    /** input validations */

    /**
     * Validate the api key
     *
     * @param string $input
     * @return string
     */
    public function validateApiKey($input)
    {
        if (empty($input) || strpos($input, 'api-') !== 0) {
            add_settings_error('smtp2go_messages', 'smtp2go_message', __('Invalid Api key entered.', SMTP_TEXT_DOMAIN));
            return get_option('smtp2go_api_key');
        }
        return sanitize_text_field($input);
    }
}
